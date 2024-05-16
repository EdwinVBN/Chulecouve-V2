import requests
from urllib.parse import urlencode

API_KEY = 'aaa909c762f438ad7c94f5d1431ce95a'
BASE_URL = 'https://api.themoviedb.org/3'
session = requests.Session()

def search_tv_show(tv_show_title):
    query = urlencode({'query': tv_show_title})
    url = f'{BASE_URL}/search/tv?api_key={API_KEY}&{query}'
    response = session.get(url)
    
    if response.status_code != 200:
        print(f'Error fetching data: {response.status_code}')
        return None
    
    data = response.json()
    if 'results' in data and len(data['results']) > 0:
        return data['results'][0]['id']
    else:
        print(f'TV show not found: {tv_show_title}')
        return None

def get_trailer_url(tv_show_id):
    url = f'{BASE_URL}/tv/{tv_show_id}/videos?api_key={API_KEY}'
    response = session.get(url)
    
    if response.status_code != 200:
        print(f'Error fetching data: {response.status_code}')
        return None
    
    data = response.json()
    if 'results' in data:
        for video in data['results']:
            if video['type'] == 'Trailer' and video['site'] == 'YouTube':
                return f'https://www.youtube.com/embed/{video["key"]}'
    return None

tv_show_titles = open('titles.txt').read().splitlines()
trailers = {}

for title in tv_show_titles:
    tv_show_id = search_tv_show(title)
    if tv_show_id:
        trailer_url = get_trailer_url(tv_show_id)
        if trailer_url:
            trailers[title] = trailer_url
            with open('trailers.txt', 'a') as file:
                file.write(f'{title} -:- {trailer_url}\n')

print(trailers)
