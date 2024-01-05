# Context

My webserver displays of the top 25 most active stocks from https://finance.yahoo.com/most-active and shows the user the varying data about that particular stock in the my webserver.

## WebScraper

I created my own webscraper in python and retrieved data such as the Name, Symbol, Price Intraday, Change, and Volume of that particular stock. Using libraries such as beautifulsoup4 and pymongo to connect my MongoDB server in Mongosh and and scrape the data as described previously. A request is sent every 3 minutes to prevent excessive requests from being sent to the server. To verify if the scraping was sucessful I printed the object ID of each document as well as using mongosh to check the documents that were stored in the collection. It is important to save the information of each document with the correct declaration (e.g saving a column of integers as integers instead of strings) Columns that have characters associated with the integer are parsed before being inserted into the document and appended later in the php script. (More information below)

## Webserver

After scraping the required data from the website, I display the contents of the webserver with a php script. My script connects to my mongodb server and accesses the collection containing the documents of the stocks. I format the contents of the collection into a table and allow the user to sort any column of their choosing in ascending order. Each column header is highlighted to prompt the user that it is clickable and can be sorted. Due to MongoDB's sorting functionality, certain concatenations must be done for the Price_Intraday, Change, and Volume in order to show correct information about what is being shown. (Sorting integers cannot be done as a string variable since strings are sorted lexicographically, causing incorrect sorting)
