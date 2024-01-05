import requests
from bs4 import BeautifulSoup
import pymongo
from pymongo import MongoClient
import time

client = MongoClient("mongodb://localhost:27017")

new_db = client ['jg_db']

col = new_db['col_name']

while True:

    response = requests.get("https://finance.yahoo.com/most-active")
    
    if response.status_code != 200:

        response = requests.get("https://finance.yahoo.com/most-active")

        if response.status_code != 200:
            print("Http request has failed twice, terminating program")
            exit(1)

    print("Request Sucessful")

    html_page = BeautifulSoup(response.text, "html.parser")

    symbols = html_page.find_all("td", {"aria-label": "Symbol"})
    names = html_page.find_all("td", {"aria-label": "Name"})
    price = html_page.find_all("td", {"aria-label": "Price (Intraday)"})
    changes = html_page.find_all("td", {"aria-label": "Change"})
    volumes = html_page.find_all("td", {"aria-label": "Volume"})

    index = 1
    for i in range(len(symbols)):

        converted_price = float(price[i].text)
        converted_change = float(changes[i].text)
        converted_vol = float(volumes[i].text[:-1])

        data = {
            'Index': index,
            'Name': names[i].text,
            'Symbol': symbols[i].text,
            'Price_Intraday': converted_price,
            'Change': converted_change,
            'Volume': converted_vol
        }
        table = col.insert_one(data)
        print(table.inserted_id)
        index += 1

    time.sleep(180)
