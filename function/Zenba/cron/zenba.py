import mysql.connector
import requests
import json
import datetime
import time
import pytz

# === CONFIG ===
DB_CONFIG = {
    'host': 'localhost',
    'user': 'zeal',
    'password': '4321',
    'database': 'zealousv2'
}


# === Get today's date in New York timezone ===
def get_ny_date():
    tz = pytz.timezone('America/New_York')
    now = datetime.datetime.now(tz)
    return now.strftime('%Y-%m-%d')

# === Fetch active campaigns from DB ===
def get_active_campaigns():
    try:
        conn = mysql.connector.connect(**DB_CONFIG)
        cursor = conn.cursor()
        cursor.execute("SELECT campaign_value FROM campaigns_details WHERE status = 'ACTIVE'")
        results = cursor.fetchall()
        cursor.close()
        conn.close()
        return [str(row[0]) for row in results]
    except mysql.connector.Error as e:
        print("MySQL Error:", str(e))
        return []

# === Make GET request and return JSON ===
def get_json(url, params):
    try:
        response = requests.get(url, params=params, timeout=10, verify=False)
        return response.json()
    except Exception as e:
        print("GET Failed:", url, "| Error:", str(e))
        return []

# === Make POST request ===
def post_data(url, data):
    try:
        response = requests.post(url, data=data, timeout=10, verify=False)
        return response.status_code
    except Exception as e:
        print("POST Failed:", url, "| Error:", str(e))
        return 0

# === MAIN SCRIPT ===
while True:
    fromdate = todate = get_ny_date()
    base_url = "http://preqvoice.com/Preq-zenba/DB"

    campaigns = get_active_campaigns()

    for campaign in campaigns:
        print("Processing campaign:", campaign)
        # 1. Get extensions
        repo_data = get_json(base_url + "/zenba_repo.php", {
            'fromdate': fromdate,
            'todate': todate,
            'campaign': campaign
        })

        for user in repo_data:
            phonenum = user.get('extension', '')
            if not phonenum:
                continue

            # 2. Fetch detailed user call data
            call_data = get_json(base_url + "/threefetchviewnew.php", {
                'fromdate': fromdate,
                'todate': todate,
                'campaign': campaign,
                'phonenum': phonenum
            })

            for entry in call_data:
                userview = entry.get('user', '')
                leadidnew = entry.get('lead_id', '')
                campaignnew = entry.get('campaign_id', '')
                call_date = entry.get('call_date', '')
                datenew = call_date[:10] if call_date else ''

                # 3. Update via POST
                status = post_data(base_url + "/updateview.php", {
                    'userview': userview,
                    'leadidnew': leadidnew,
                    'campaignnew': campaignnew,
                    'datenew': datenew
                })

                print("Updated:", leadidnew, "| Status:", status)
        
        # Optional delay between campaigns
        print("Process Completed")
        time.sleep(1)  # 1 second delay

