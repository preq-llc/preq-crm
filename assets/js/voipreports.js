$(document).ready(function () {
var fromdate=""; var todate="";var fetchip=""; var fromtodatevalues=""; var todatevalue="";
  // Your button click handler
// Button click handler
$("#btnsfetchd").on("click", function () {
   fromdate = $("#fromdatefetch").val();
   todate = $("#todatefetch").val();
   fetchip = $("#fetchcampip").val();

   fromtodatevalues = fromdate;
   todatevalue = todate;

  if (fromdate !== '' && todate !== '' && fetchip !== '') {
    const fetchipvalue = fetchip;
    fromtodateipaddress(fromtodatevalues, todatevalue, fetchipvalue);
  } else {
    fromtodateipaddressview2(fromtodatevalues, todatevalue);
  }
});

function fromtodateipaddress(fromdatevalues, todatevalue, fetchipvalue) {
  $.ajax({
    url: "ajax/report/voipdata.php?action=view",
    type: "GET",
    dataType: "json",
    data: {
      fromdatevalues: fromdatevalues,
      todatevalue: todatevalue,
      fetchipvalue: fetchipvalue
    },
    success: function (data) {
      if (Array.isArray(data) && data.length > 0) {
        let totalcalls = 0;
        let summaryArray = [];

        // Calculate total calls
        $.each(data, function (index, user) {
          totalcalls += parseInt(user.calls) || 0;
        });

        // Prepare batch summary
        $.each(data, function (index, user) {
          let server_ip = user.server_ip;
          let campaign_id = user.campaign_id;
          let call_date = user.call_date;
          let calls = parseInt(user.calls) || 0;
          let am = parseInt(user.AM) || 0;
          let human = parseInt(user.Human) || 0;
          let totalAnswered = am + human;
          let answeredPercentage = calls ? (totalAnswered / calls) * 100 : 0;

          summaryArray.push({
            campaign_id,
            calls,
            am,
            human,
            totalAnswered,
            answeredPercentage,
            call_date,
            server_ip
          });
        });

        // Send batch summary
        $.ajax({
          url: "ajax/report/fetch_voip_usage.php?action=insertBatchSummary",
          type: "POST",
          data: JSON.stringify({ summaries: summaryArray }),
          contentType: "application/json",
          beforeSend: function () {
            $("#loader").show();
          },
          success: function (res) {
            console.log("Batch insert success", res);
             fromtodateipaddressviewhours(fromtodatevalues, todatevalue, fetchipvalue);
          },
          error: function (xhr, status, error) {
            console.error("Batch insert error:", status, error);
          },
          complete: function () {
            //$("#loader").hide();
          }
        });

      } else {
        alert("No records found for that date.");
      }
    },
    error: function (xhr, status, error) {
      console.error("Data fetch error:", status, error);
    }
  });
}

// hours  report add  //
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
                    // $("#loader").show();
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
//hours report add//

function fromtodateipaddressview2(fromdatevalues, todatevalue) {
  $.ajax({
    url: "ajax/report/fetch_voip_usage.php?action=fetchvoipusage",
    type: "GET",
    dataType: "json",
    data: {
      fromdatevalues: fromdatevalues,
      todatevalue: todatevalue
    },
    success: function (datasucess) {
      const voipUsage = parseFloat(datasucess.voipUsage) || 0;

      $.ajax({
        url: "ajax/report/fetch_voip_usage.php?action=fetchvoipsummary",
        type: "GET",
        dataType: "json",
        data: {
          fromdatevalues: fromdatevalues,
          todatevalue: todatevalue
        },
        success: function (data) {
          let body = "";
          let alltotalCalls = 0;
          let summaryArray = [];

          if (Array.isArray(data) && data.length > 0) {
            $.each(data, function (index, user) {
              alltotalCalls += parseInt(user.totalcalls) || 0;
            });

            $.each(data, function (index, user) {
            const calls = parseInt(user.totalcalls) || 0;
            const am = parseInt(user.AM) || 0;
            const human = parseInt(user.Human) || 0;
            const totalAnswered = parseInt(user.aa_ha) || 0;
            const answeredPercentage = parseFloat(user.percentage) || 0;
            const totalHrs = parseFloat(user.total_hrs) || 0;
            const campaign_id = user.campaign_id;
            const entry_date = user.entry_date;
            const server_ip = user.server_ip;

            let callPercentage = 0;
            let userVoipUsage = 0;

            if (campaign_id !== 'TAX') {
              callPercentage = alltotalCalls ? parseFloat(((calls / alltotalCalls) * 100).toFixed(6)) : 0;
              userVoipUsage = voipUsage ? (voipUsage * callPercentage) / 100 : 0;
            }

            summaryArray.push({
              campaign_id,
              callPercentage: parseFloat(callPercentage.toFixed(6)),
              userVoipUsage: parseFloat(userVoipUsage.toFixed(6)),
              entry_date,
              server_ip
            });

            body += `
              <tr>
                <td>${campaign_id || '-'}</td>
                <td>${calls}</td>
                <td>${am}</td>
                <td>${human}</td>
                <td>${totalAnswered}</td>
                <td>${answeredPercentage.toFixed(2)}%</td>
                <td>${callPercentage.toFixed(2)}%</td>
                <td>${userVoipUsage.toFixed(2)}</td>
                <td>${totalHrs.toFixed(2)}</td>
              </tr>
            `;
          });


            // Send batch update once
            $.ajax({
              url: "ajax/report/fetch_voip_usage.php?action=updatedcall_voipusage",
              type: "POST",
              data: JSON.stringify({ summaries: summaryArray }),
              contentType: "application/json",
              beforeSend: function () {
                $("#loader").show();
              },
              success: function (res) {
                console.log("Batch insert success", res);
              },
              error: function (xhr, status, error) {
                console.error("Batch insert error:", status, error);
              },
              complete: function () {
                $("#loader").hide();
              }
            });

          } else {
            alert("No records found for that date.");
            body = '<tr><td colspan="9" class="text-center">No Records Found</td></tr>';
          }

          $("#fetchalldata").html(body);
          fromtodateipaddressview1(fromdatevalues, todatevalue);
        },
        error: function (xhr, status, error) {
          console.error("Summary fetch error:", status, error);
        }
      });
    },
    error: function (xhr, status, error) {
      console.error("Error fetching VOIP usage:", status, error);
      console.log("Response:", xhr.responseText);
    }
  });
}


function fromtodateipaddressview1(fromdatevalues, todatevalue) {
  $.ajax({
    url: "ajax/report/fetch_voip_usage.php?action=voipreport_count",
    type: "GET",
    dataType: "json",
    data: {
      fromdatevalues: fromdatevalues,
      todatevalue: todatevalue
    },
    success: function (data) {
      if (data && typeof data === 'object') {
        const totalCampaigns = 6; // Update this if dynamic
        const totalPercentage = parseFloat(data.total_call_percentage) || 0;

        const overallPercentage = totalCampaigns !== 0
          ? (totalPercentage / totalCampaigns).toFixed(2)
          : '0.00';

        const foot = `
          <tr>
            <th>Total</th>
            <th>${data.total_call || 0}</th>
            <th>${data.total_AM || 0}</th>
            <th>${data.total_Human || 0}</th>
            <th>${data.total_AAHA || 0}</th>
            <th>${overallPercentage}%</th>
            <th>${parseFloat(data.total_call_percentage || 0).toFixed(2)}%</th>
            <th>${parseFloat(data.total_voip_usage || 0).toFixed(2)}</th>
            <th>${parseFloat(data.total_hours || 0).toFixed(2)}</th>
          </tr>
        `;
        $("#totalFooter").html(foot);
      } else {
        $("#totalFooter").html(`<tr><td colspan="9" class="text-center">No summary data found</td></tr>`);
      }
    },
    error: function (xhr, status, error) {
      console.error("Summary fetch error:", status, error);
      $("#totalFooter").html(`<tr><td colspan="9" class="text-center">Error fetching data</td></tr>`);
    }
  });
}

function overall_fetch(fromdatevalues, todatevalue, fetchipvalue) {
  $.ajax({
    url: "ajax/report/voipdata.php?action=all",
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
      var amadd = 0;
      var humanadd = 0;
      var totalview = "";
      var totalcals = 0;

      overallcountcount = datasucess.length;
      $.each(datasucess, function (index, user) {

        totalcals = parseInt(user.Totalcalls)

        amaddview = parseInt(user.AM);
        humanaddviwe = parseInt(user.Human);

        totalprecntage = (amaddview + humanaddviwe);


        body += ' <tr">' +
          '<td>' + user.campaign_id + '</td>' +
          '<td>' + user.Totalcalls + '</td>' +
          '<td>' + user.AM + '</td>' +
          '<td>' + user.Human + '</td>' +
          '<td>' + (amaddview + humanaddviwe) + '</td>' +
          '<td>' + (totalprecntage / totalcals * 100).toFixed(2) + ' % </td>' +
          '</tr>'
      });
      $("#fetchalldata").html("");
      $("#fetchalldata").html(body);
    },

  });
}

function overall_live_data(fromdatevalues, todatevalue, fetchipvalue) {
  $.ajax({
    url: "ajax/report/voipdata.php?action=all_live_data",
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
      var amadd = 0;
      var humanadd = 0;
      var totalview = "";
      var totalcals = 0;

      overallcountcount = datasucess.length;
      $.each(datasucess, function (index, user) {

        totalcals = parseInt(user.Totalcalls)

        amaddview = parseInt(user.AM);
        humanaddviwe = parseInt(user.Human);

        totalprecntage = (amaddview + humanaddviwe);


        body += ' <tr">' +
          '<td>' + user.campaign_id + '</td>' +
          '<td>' + user.Totalcalls + '</td>' +
          '<td>' + user.AM + '</td>' +
          '<td>' + user.Human + '</td>' +
          '<td>' + (amaddview + humanaddviwe) + '</td>' +
          '<td>' + (totalprecntage / totalcals * 100).toFixed(2) + ' % </td>' +

          '</tr>'


      });
      $("#fetchalldata").html("");
      $("#fetchalldata").html(body);


    },

  });
}
});

/// Hours report fetching////


// function fromtodateipaddressviewhours(fromdatevalues, todatevalue, fetchipvalue) {
//    $.ajax({
//       url: "ajax/report/voipdatahrs.php?action=view",
//       type: "GET",
//       dataType: "json",
//       data: {
//          fromdatevalues: fromdatevalues,
//          todatevalue: todatevalue,
//          fetchipvalue: fetchipvalue
//       },
//       success: function (datasucess) {
//          if (!Array.isArray(datasucess)) {
//             console.error("Unexpected response format:", datasucess);
//             return;
//          }

//          let summaryArray = [];

//          datasucess.forEach(user => {
//             const hrs = parseFloat(user.Hrs / 3600).toFixed(2);  // Convert seconds to hours
//             const campaign_id = user.camp || '';
//             const event_time = user.event_time ? user.event_time.substring(0, 10) : ''; // Ensure it's 'YYYY-MM-DD'
//             const server_ip = user.server_ip || '';

//             if (campaign_id && event_time && server_ip) {
//                summaryArray.push({ campaign_id, hrs: parseFloat(hrs), event_time, server_ip });
//             } else {
//                console.warn("Skipping incomplete entry:", user);
//             }
//          });

//          if (summaryArray.length > 0) {
//             $.ajax({
//                url: "ajax/report/fetch_voip_usage.php?action=updatebatchsummary",
//                type: "POST",
//                data: JSON.stringify({ summaries: summaryArray }),
//                contentType: "application/json",

//                beforeSend: function () {
//                   // Show the loader
//                   $("#loader").show();
//                },

//                success: function (res) {
//                   console.log("Batch update success", res);
//                },

//                error: function (xhr, status, error) {
//                   console.error("Batch update error:", status, error);
//                   console.log("Server response:", xhr.responseText);
//                },

//                complete: function () {
//                   // Hide the loader after request finishes (success or error)
//                   $("#loader").hide();
//                }
//             });

//          } else {
//             console.warn("No valid summary data to send.");
//          }

//          if (['192.168.200.51', '192.168.200.71', '192.168.200.111', '192.168.200.131'].includes(fetchipvalue)) {
//             overall_hrs_fetch(fromdatevalues, todatevalue, fetchipvalue);
//          }
//       },
//       error: function (xhr, status, error) {
//          console.error("AJAX Error:", status, error);
//          console.log("Response:", xhr.responseText);
//       }
//    });
// }


