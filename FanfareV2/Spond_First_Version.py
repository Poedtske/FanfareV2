import asyncio
from spond import spond
import datetime

username = 'robbe.poedts@hotmail.be'
password = '159951bb'
group_id = '4B54CE00ED8F4936840114345105B38C'  # fake

async def get_events_spond():
    s = spond.Spond(username=username, password=password)
    group = await s.get_group(group_id)
    events= await s.get_events(group_id=group_id, min_start=datetime.datetime.now())
    eventlist=[]
    for i, event in enumerate(events):
        # print(f"Evenement: {event['heading']}\n")
        # print(f"Start: {event['startTimestamp']}\n")
        # print(f"Eind: {event['endTimestamp']}\n")
        # location=event['location']
        # print(f"Locatie: {location['feature']}\n")
        # print("-----------------------------------")
        if event['heading']!='Repetitie':
            eventlist.append(event)

    # for event in eventlist:
    #     print(f"Evenement: {event['heading']}\n")
    #     print(f"Start: {event['startTimestamp']}\n")
    #     print(f"Eind: {event['endTimestamp']}\n")
    #     print(f"Locatie: {event['location']['feature']}\n")
    #     print("-----------------------------------")
    print(event)

    # print(eventlist[2])
    print(group['name'])
    await s.clientsession.close()

asyncio.run(get_events_spond())
