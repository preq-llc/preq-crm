$(document).ready(function () {


   $("#btnsfetchd").on("click", function () {

      var fromdate = $("#fromdatefetch").val();
      var todate = $("#todatefetch").val();
      var fetchip = $("#fetchcampip").val();

      if (fromdate != '' && todate !== '' && fetchip !== '') {
         fromdatevalues = fromdate;
         todatevalue = todate;
         fetchipvalue = fetchip;
         fromtodateipaddressviewhours(fromdatevalues, todatevalue, fetchipvalue);
   

      }

   });


   function fromtodateipaddressviewhours(fromdatevalues, todatevalue, fetchipvalue) {
      $.ajax({
         url: "ajax/report/voipdatahrs.php?action=view",
         type: "GET",
         dataType: "json",
         data: {
            fromdatevalues: fromdatevalues,
            todatevalue: todatevalue,
            fetchipvalue: fetchipvalue
         },
         success: function (datasucess) {
            if (!Array.isArray(datasucess)) {
               console.error("Unexpected response format:", datasucess);
               return;
            }

            let summaryArray = [];

            datasucess.forEach(user => {
               const hrs = parseFloat(user.Hrs / 3600).toFixed(2);  // Convert seconds to hours
               const campaign_id = user.camp || '';
               const event_time = user.event_time ? user.event_time.substring(0, 10) : ''; // Ensure it's 'YYYY-MM-DD'
               const server_ip = user.server_ip || '';

               if (campaign_id && event_time && server_ip) {
                  summaryArray.push({ campaign_id, hrs: parseFloat(hrs), event_time, server_ip });
               } else {
                  console.warn("Skipping incomplete entry:", user);
               }
            });

            if (summaryArray.length > 0) {
               $.ajax({
                  url: "ajax/report/fetch_voip_usage.php?action=updatebatchsummary",
                  type: "POST",
                  data: JSON.stringify({ summaries: summaryArray }),
                  contentType: "application/json",

                  beforeSend: function () {
                     // Show the loader
                     $("#loader").show();
                  },

                  success: function (res) {
                     console.log("Batch update success", res);
                  },

                  error: function (xhr, status, error) {
                     console.error("Batch update error:", status, error);
                     console.log("Server response:", xhr.responseText);
                  },

                  complete: function () {
                     // Hide the loader after request finishes (success or error)
                     $("#loader").hide();
                  }
               });

            } else {
               console.warn("No valid summary data to send.");
            }

            if (['192.168.200.51', '192.168.200.71', '192.168.200.111', '192.168.200.131'].includes(fetchipvalue)) {
               overall_hrs_fetch(fromdatevalues, todatevalue, fetchipvalue);
            }
         },
         error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response:", xhr.responseText);
         }
      });
   }

});

function overall_hrs_fetch(fromdatevalues, todatevalue, fetchipvalue) {
   $.ajax({
      url: "ajax/report/voipdatahrs.php?action=all",
      type: "GET",
      data: {

         fromdatevalues: fromdatevalues,
         todatevalue: todatevalue,
         fetchipvalue: fetchipvalue,
      },

      success: function (data) {



         var datasucess;
         datasucess = JSON.parse(data);
         console.log(datasucess);
         var overallcountcount = "";
         var body = "";


         overallcountcount = datasucess.length;
         $.each(datasucess, function (index, user) {


            body += ' <tr">' +

               '<td>' + parseFloat(user.Hrs / 3600).toFixed(2) + '</td>' +
               '<td>' + user.camp + '</td>' +
               '</tr>'


         });
         $("#totalhrsfetch").html("");
         $("#totalhrsfetch").html(body);



      },

   });
}

