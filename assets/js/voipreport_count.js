$(document).ready(function () {


    $("#btnsfetchd").on("click", function () {

        var fromdate = $("#fromdatefetch").val();
        var todate = $("#todatefetch").val();


        if (fromdate != '' && todate !== '') {
            fromdatevalues = fromdate;
            todatevalue = todate;


            fromtodateipaddressview(fromdatevalues, todatevalue);

        }

    });

    function fromtodateipaddressview(fromdatevalues, todatevalue) {
        // First fetch the VOIP usage summary (if needed before the count)
        $.ajax({
            url: "fetch_voip_usage.php?action=voipreport_count",
            type: "GET",
            dataType: "json",
            data: {
                fromdatevalues: fromdatevalues,
                todatevalue: todatevalue
            },
            success: function (data) {
                console.log("Summary data:", data);

                if (data && typeof data === 'object') {
                    let foot = `
                <tr>
                  <th>Total</th>
                  <th>${data.totalcall || 0}</th>
                  <th>${data.total_AM || 0}</th>
                  <th>${data.total_Human || 0}</th>
                  <th>${data.total_aaha || 0}</th>
                  <th>${parseFloat(data.total_percentage || 0).toFixed(2)}%</th>
                  <th>${parseFloat(data.total_callpercentage || 0).toFixed(2)}%</th>
                  <th>${parseFloat(data.total_voipusage || 0).toFixed(2)}</th>
                   <th>${parseFloat(data.total_hrs || 0).toFixed(2)}</th>
                </tr>
              `;
                    $("#totalFooter").html(foot);
                } else {
                    $("#totalFooter").html(`<tr><td colspan="8" class="text-center">No summary data found</td></tr>`);
                }
            },
            error: function (xhr, status, error) {
                console.error("Summary fetch error:", status, error);
                $("#totalFooter").html(`<tr><td colspan="8" class="text-center">Error fetching data</td></tr>`);
            }
        });
    }


});