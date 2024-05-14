#connect to hobo database file database.sql 
import sqlite3

def connect():
    return sqlite3.connect("database.sql")

#print out select * from serie
def select_all():
    conn = connect()
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM serie")
    return cursor.fetchall()

conn = connect()
cursor = conn.cursor()
cursor.execute("SELECT * FROM serie")
print(cursor.fetchall())