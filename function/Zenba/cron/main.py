import mysql.connector
import requests
import time

# === DB CONFIG ===
DB_CONFIG = {
    'host': 'localhost',
    'user': 'zeal',
    'password': '4321',
    'database': 'zealousv2'
}

def get_active_campaigns():
    try:
        conn = mysql.connector.connect(**DB_CONFIG)
        cursor = conn.cursor()
        cursor.execute("SELECT campaign_value FROM campaigns_details WHERE status = 'ACTIVE'")
        results = cursor.fetchall()
        cursor.close()
        conn.close()
        return [row[0] for row in results]
    except mysql.connector.Error as err:
        print("MySQL Error:", err)
        return []

def trigger_campaign(campaign):
    url = "https://preqvoice.com/Preq-zenba/zenba-auto.php"
    params = {'campaign': campaign}
    try:
        response = requests.get(url, params=params, timeout=10, verify=False)
        print("Triggered for:", campaign)
    except Exception as e:
        print("Failed to trigger for:", campaign, "| Error:", str(e))

while True:
    print("Starting campaign run...")
    campaigns = get_active_campaigns()
    for campaign in campaigns:
        print(campaign)
        # trigger_campaign(campaign)
    print("Run finished. Sleeping for 2 seconds...\n")
    time.sleep(2)