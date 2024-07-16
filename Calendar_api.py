import datetime
import os.path
import json
import sys

from google.auth.transport.requests import Request
from google.oauth2.credentials import Credentials
from google_auth_oauthlib.flow import InstalledAppFlow
from googleapiclient.discovery import build
from googleapiclient.errors import HttpError

# If modifying these scopes, delete the file token.json.


class Calendar_api:
    def __init__(self,json):

        self.FILE_PATH='Calendar.json'
        SCOPES = ["https://www.googleapis.com/auth/calendar"]

        """Shows basic usage of the Google Calendar API.
        Prints the start and name of the next 10 events on the user's calendar.
        """
        self.creds=None
        self.id=None
        # The file token.json stores the user's access and refresh tokens, and is
        # created automatically when the authorization flow completes for the first
        # time.
        if os.path.exists("token.json"):
            self.creds = Credentials.from_authorized_user_file("token.json", SCOPES)
        # If there are no (valid) credentials available, let the user log in.
        if not self.creds or not self.creds.valid:
            if self.creds and self.creds.expired and self.creds.refresh_token:
                self.creds.refresh(Request())
            else:
                flow = InstalledAppFlow.from_client_secrets_file(
                    "../credentials.json", SCOPES
                )
                self.creds = flow.run_local_server(port=0)
                # Save the credentials for the next run
            with open("token.json", "w") as token:
                token.write(self.creds.to_json())

        object=json
        # print(object.get('event'))
        if(object['action']=='create'):
            self.id=self.create(object.get("event"))
        elif(object.get('action')=='update'):
            self.update(object.get("event"))
        elif(object.get('action')=='delete'):
            self.delete(object.get("event").get('calendar_id'))
        else:
            # print('HAHAHAHAHA')
            return
        self.deleteJson()
    def dateFormat(self, date, time, action='create'):
        # Check if time is in HH:MM format
        if len(time) == 5:
            time += ":00"
        return f"{date}T{time}+02:00"

    # Example usage
    # obj = YourClass()  # Replace YourClass with the actual class name
    # print(obj.date_format("2024-07-13", "00:00", "create"))
    # print(obj.date_format("2024-07-13", "00:00:00", "update"))

    def create(self,event):
        try:
            service = build("calendar", "v3", credentials=self.creds)

            event={
            "summary":event['title'],
            "location":event['location'],
            "description":event['description'],
            "colorId":6,
            "start":{
                "dateTime":self.dateFormat(event['date'],event['start_time']),
                "timeZone": "Europe/Brussels"
            },
            "end":{
                "dateTime":self.dateFormat(event['date'],event['end_time']),
                "timeZone": "Europe/Brussels"
            },
            }
            # print(event)
            event=service.events().insert(calendarId="k.f.demoedigevrienden@gmail.com",body=event).execute()

            print(event.get('id'))
            # json_output = json.dumps(event.get('id'), ensure_ascii=False, indent=4)
            # sys.stdout.buffer.write(json_output.encode('utf-8'))
            # return
            # print(f"Event updated {event.get('htmlLink')}")
        except HttpError as error:
            print(f"An error occurred: {error}")
            return

    def update(self,event):
        try:
            service = build("calendar", "v3", credentials=self.creds)
            calendar_id=event.get('calendar_id')
            event={
            "summary":event['title'],
            "location":event['location'],
            "description":event['description'],
            "colorId":6,
            "start":{
                "dateTime":self.dateFormat(event['date'],event['start_time']),
                "timeZone": "Europe/Brussels"
            },
            "end":{
                "dateTime":self.dateFormat(event['date'],event['end_time']),
                "timeZone": "Europe/Brussels"
            },
            }

            event=service.events().patch(calendarId="k.f.demoedigevrienden@gmail.com",eventId=calendar_id,body=event).execute()

            print(event)
        except HttpError as error:
            print(f"An error occurred: {error}")
            return

    def delete(self,event_id):
        try:
            service = build("calendar", "v3", credentials=self.creds)
            service.events().delete(calendarId="k.f.demoedigevrienden@gmail.com",eventId=event_id).execute()
            print(f"Event deleted")
        except HttpError as error:
            print(f"An error occurred: {error}")
            return


    def readJson(self):
        try:
            with open(self.FILE_PATH, 'r') as file:
                first_line = file.readline().strip()
                data = json.loads(first_line)
                return data
        except FileNotFoundError:
            print(f"File {self.FILE_PATH} not found when writing.")
            return
        except json.JSONDecodeError:
            print(f"Error decoding JSON from the file {self.FILE_PATH}.")
        except Exception as e:
            print(f"An error occurred: {e}")
            return {}
    def deleteJson(self):
        try:
            with open(self.FILE_PATH, 'r') as file:
                lines = file.readlines()

            with open(self.FILE_PATH, 'w') as file:
                file.writelines(lines[1:])

            # print("First line deleted from JSON file.")
        except FileNotFoundError:
            print(f"File {self.FILE_PATH} not found when deleting.")
        except Exception as e:
            print(f"An error occurred: {e}")
            # return



if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python test.py '<json_string>'")
    else:
        json_str = sys.argv[1]
        json_str = json_str.replace('*', '"')
        Calendar_api(json.loads(json_str))


