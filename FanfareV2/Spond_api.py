import asyncio
import datetime
from spond import spond  # Assuming spond is a package you have installed
import json
import sys

import details

username = details.USERNAME
password = details.PASSWORD
group_id = details.GROUP_ID

async def get_events_spond():
    s = spond.Spond(username=username, password=password)
    group = await s.get_group(group_id)
    events = await s.get_events(group_id=group_id, min_start=datetime.datetime.now())
    eventlist = []

    for event in events:
        if 'repetitie' not in event['heading'].lower():
            eventlist.append(event)

    event_dict = {}
    for index, event in enumerate(eventlist):
        event_details = {
            "ID":event['id'],
            "title": event['heading'],
            "start": event['startTimestamp'],
            "end": event['endTimestamp'],
            "location": event['location']['feature']
        }

        # Add description if it exists
        if 'description' in event:
            event_details['description'] = event['description']

        event_dict[index] = event_details

    # print(group['name'])

    await s.clientsession.close()
    return event_dict

if __name__ == "__main__":
    events = asyncio.run(get_events_spond())
    json_output = json.dumps(events, ensure_ascii=False, indent=4)
    sys.stdout.buffer.write(json_output.encode('utf-8'))