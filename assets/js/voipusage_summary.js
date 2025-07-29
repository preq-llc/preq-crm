$(document).ready(function () {


    $("#btnsfetchd").on("click", function () {
 
       var fromdate = $("#fromdatefetch").val();
       var todate = $("#todatefetch").val();
      
 
       if (fromdate != '' && todate !== '' ) {
          fromdatevalues = fromdate;
          todatevalue = todate;
          
 
          fromtodateipaddressview(fromdatevalues, todatevalue);
 
       }
 
    });
    function fromtodateipaddressview(fromdatevalues, todatevalue) {
      $.ajax({
        url: "ajax/report/fetch_voip_usage.php?action=fetchvoipusage",
        type: "GET",
        dataType: "json",
        data: {
          fromdatevalues: fromdatevalues,
          todatevalue: todatevalue
        },
        success: function (datasucess) {
          let voipUsage = parseFloat(datasucess.voipUsage) || 0;
          console.log("VOIP Usage:", voipUsage);
    
          $.ajax({
            url: "ajax/report/fetch_voip_usage.php?action=fetchvoipsummary",
            type: "GET",
            dataType: "json",
            data: {
              fromdatevalues: fromdatevalues,
              todatevalue: todatevalue
            },
            success: function (data) {
              console.log("Summary data:", data);
    
              let body = "";
              let alltotalCalls = 0;
              let summaryArray = []; // Initialize the summaryArray to store the data for batch insert
    
              // First loop: calculate total calls
              if (Array.isArray(data) && data.length > 0) {
                $.each(data, function (index, user) {
                  alltotalCalls += parseInt(user.totalcalls) || 0;
                });
    
                // Second loop: generate table rows and populate summaryArray
                $.each(data, function (index, user) {
                  let calls = parseInt(user.totalcalls) || 0;
                  let am = parseInt(user.AM) || 0;
                  let human = parseInt(user.Human) || 0;
                  let totalAnswered = parseInt(user.aa_ha) || 0;
                  let answeredPercentage = parseFloat(user.percentage) || 0;
                  let callPercentage = alltotalCalls ? (calls / alltotalCalls) * 100 : 0;
                  let userVoipUsage = (typeof voipUsage !== 'undefined') ? (voipUsage * callPercentage) / 100 : 0;
                  let totalHrs = parseFloat(user.total_hrs) || 0;
                  let campaign_id = user.campaign_id;
                  let entry_date = user.entry_date;
                  let server_ip = user.server_ip;
    
                  // Add to summaryArray for batch insertion
                  summaryArray.push({
                    campaign_id,
                    callPercentage,
                    userVoipUsage,
                    entry_date,
                    server_ip
                  });
    
                  // Build table rows
                  body += '<tr>' +
                    '<td>' + (user.campaign_id || '-') + '</td>' +
                    '<td>' + calls + '</td>' +
                    '<td>' + am + '</td>' +
                    '<td>' + human + '</td>' +
                    '<td>' + totalAnswered + '</td>' +
                    '<td>' + answeredPercentage.toFixed(2) + ' %</td>' +
                    '<td>' + callPercentage.toFixed(2) + ' %</td>' +
                    '<td>' + userVoipUsage.toFixed(2) + '</td>' +
                    '<td>' + totalHrs.toFixed(2) + '</td>' +
                    '</tr>';
                });
    
                // Send campaignsummary insert to PHP after table generation
                $.ajax({
                  url: "ajax/report/fetch_voip_usage.php?action=updatedcall_voipusage",
                  type: "POST",
                  data: JSON.stringify({ summaries: summaryArray }),
                  contentType: "application/json",
                  beforeSend: function () {
                    $("#loader").show(); // Show loading image
                  },
                  success: function (res) {
                    console.log("Batch insert success", res);
                    $("#loader").hide(); // Hide loading image
                  },
                  error: function (xhr, status, error) {
                    console.error("Batch insert error:", status, error);
                    $("#loader").hide(); // Hide loading image on error too
                  }
                });
                
    
              } else {
                body = '<tr><td colspan="9" class="text-center">No Records Found</td></tr>';
              }
    
              // Display the generated body in the table
              $("#fetchalldata").html(body);
            
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
    
      
      
 });