import tls_client
import threading
import numpy as np
import time

class Scraper:
    def __init__(self):
        self.session = tls_client.Session(client_identifier='firefox_125', random_tls_extension_order=True)
        self.cookies = {
            'session-id': '147-4647675-3051305',
            'session-id-time': '2082787201l',
            'csm-hit': 'tb:HZJVHP7D0PPS39YNE2TX+s-J0JPRGDF7CASGAXXYAPT^|1715634049041&t:1715634049041&adb:adblk_yes',
            'ubid-main': '134-1083134-0146253',
            'ad-oo': '0',
            'session-token': 'wiVoaFTg6zeZuX2adMX3OVvZ1MxZhifQeXFBR/1iabOJpN2QThaopVoI/tm0JEtGHcWNCO4tQ/7B3iOe3rTN+pw3FFHXljI3HmqVeHIWrlIaivFS+r/G9lEbWUL/JxCf8BCeJZo7eVVM4rSsDfsOojKwYsphak0pbz9LVheuaq/h1Ma2cBlUrX0CnCCSPuG7izOtlWy6SRwYtuRYY6FBu8PvcElG8t6Rt6E9uKxHjpYqn+wji0xBu8rcPQjRJOvXJmJ+ghPCIfjkVCPh8k7RZPbDV1oerNK2KQo3XA7HS7R6ECl9HgP4Gpu+elktHvHMN5G18j9K2Mx1HI7O8QVSNASkjjlFWMUm',
            'ci': 'eyJhY3QiOiJDUC1qWEFBUC1qWEFBRjRBQkNFTmZyLWdBQUFBQUFBQUFCYW1HNndCMkdvc05UNGF0aHJERFh1R3dZYkR3MlREWmVHMFlicUFBRUFBQUFBIiwiZ2N0IjoiQ1AtalhBQVAtalhBQUY0QUJDRU5BYkVnQU5MZ0FBQUFBQmFnSG1RUGdBRkFBTkFBeUFCd0FFRUFKQUFsQUJPQUNvQUZvQU1vQWFBQnFBRDBBSVVBUkFCR2dDWUFKd0FVQUFwQUJVQUM3QUdFQVlnQXpBQnVnRGtBT1lBZmdCQUFDRUFFUkFJNEFqd0JOQUNsQUZhQUxnQWFvQThRQi1nRVJBSXRBUndCSFFDVEFFdEFKd0FVMEFySUJYZ0RBZ0dLQU02QWNJQTRnQjFBRDlBSDhBUkFBalVCSG9DalFGaGdMekFYdUF3UUJsZ0R6QUFBZ0FBRkFvQU1BQVFmUUNRQVlBQWctZ09nQXdBQkI5QWxBQmdBQ0Q2QlNBREFBRUgwQXdBR0FBSVBvQ2dBTUFBUWZRR0FBWUFBZy1nUUFBd0FCQjlBUUFQQUJBQUNRQUZRQU5ZQXdnREVBR1lBT1lBZ0FCU2dEVkFKYUFWa0Fyd0J3Z0ZoZ0EuY0FBQUFBQUFBQUEiLCJwdXJwb3NlcyI6WyIxIiwiMiIsIjQiLCI3IiwiOSIsIjEwIiwiMTEiXSwidmVuZG9ycyI6WyI2OCIsIjc3IiwiNzU1IiwiNzkzIiwiODA0IiwiMTEyNiIsIjUwMDI1IiwiNTAwMzAiXX0',
        }

        self.headers = {
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:125.0) Gecko/20100101 Firefox/125.0',
            'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
            'Accept-Language': 'nl,en-US;q=0.7,en;q=0.3',
            # 'Accept-Encoding': 'gzip, deflate, br',
            'Alt-Used': 'www.imdb.com',
            'Connection': 'keep-alive',
            'Referer': 'https://www.imdb.com/find/?q=orange&ref_=nv_sr_sm',
            # 'Cookie': 'session-id=147-4647675-3051305; session-id-time=2082787201l; csm-hit=tb:HZJVHP7D0PPS39YNE2TX+s-J0JPRGDF7CASGAXXYAPT^|1715634049041&t:1715634049041&adb:adblk_yes; ubid-main=134-1083134-0146253; ad-oo=0; session-token=wiVoaFTg6zeZuX2adMX3OVvZ1MxZhifQeXFBR/1iabOJpN2QThaopVoI/tm0JEtGHcWNCO4tQ/7B3iOe3rTN+pw3FFHXljI3HmqVeHIWrlIaivFS+r/G9lEbWUL/JxCf8BCeJZo7eVVM4rSsDfsOojKwYsphak0pbz9LVheuaq/h1Ma2cBlUrX0CnCCSPuG7izOtlWy6SRwYtuRYY6FBu8PvcElG8t6Rt6E9uKxHjpYqn+wji0xBu8rcPQjRJOvXJmJ+ghPCIfjkVCPh8k7RZPbDV1oerNK2KQo3XA7HS7R6ECl9HgP4Gpu+elktHvHMN5G18j9K2Mx1HI7O8QVSNASkjjlFWMUm; ci=eyJhY3QiOiJDUC1qWEFBUC1qWEFBRjRBQkNFTmZyLWdBQUFBQUFBQUFCYW1HNndCMkdvc05UNGF0aHJERFh1R3dZYkR3MlREWmVHMFlicUFBRUFBQUFBIiwiZ2N0IjoiQ1AtalhBQVAtalhBQUY0QUJDRU5BYkVnQU5MZ0FBQUFBQmFnSG1RUGdBRkFBTkFBeUFCd0FFRUFKQUFsQUJPQUNvQUZvQU1vQWFBQnFBRDBBSVVBUkFCR2dDWUFKd0FVQUFwQUJVQUM3QUdFQVlnQXpBQnVnRGtBT1lBZmdCQUFDRUFFUkFJNEFqd0JOQUNsQUZhQUxnQWFvQThRQi1nRVJBSXRBUndCSFFDVEFFdEFKd0FVMEFySUJYZ0RBZ0dLQU02QWNJQTRnQjFBRDlBSDhBUkFBalVCSG9DalFGaGdMekFYdUF3UUJsZ0R6QUFBZ0FBRkFvQU1BQVFmUUNRQVlBQWctZ09nQXdBQkI5QWxBQmdBQ0Q2QlNBREFBRUgwQXdBR0FBSVBvQ2dBTUFBUWZRR0FBWUFBZy1nUUFBd0FCQjlBUUFQQUJBQUNRQUZRQU5ZQXdnREVBR1lBT1lBZ0FCU2dEVkFKYUFWa0Fyd0J3Z0ZoZ0EuY0FBQUFBQUFBQUEiLCJwdXJwb3NlcyI6WyIxIiwiMiIsIjQiLCI3IiwiOSIsIjEwIiwiMTEiXSwidmVuZG9ycyI6WyI2OCIsIjc3IiwiNzU1IiwiNzkzIiwiODA0IiwiMTEyNiIsIjUwMDI1IiwiNTAwMzAiXX0',
            'Upgrade-Insecure-Requests': '1',
            'Sec-Fetch-Dest': 'document',
            'Sec-Fetch-Mode': 'navigate',
            'Sec-Fetch-Site': 'same-origin',
            'Sec-Fetch-User': '?1',
            # Requests doesn't support trailers
            # 'TE': 'trailers',
        }

    def load_queries(self, file_path):
        with open(file_path, 'r') as file:
            self.queries = file.read().splitlines()
        print(f'Loaded {len(self.queries)} queries')

    def search_query(self, query):
        print(f"Searching for: {query}")
        params = {'q': query, 'ref_': 'nv_sr_sm'}
        response = self.session.get('https://www.imdb.com/find', params=params, cookies=self.cookies, headers=self.headers, allow_redirects=True)
        print("Searching done, now filtering HTML Code...")
        return response.text

    def get_item(self, text, retries=0):
        if retries == 5:
            return None
        try:
            item_found = text.split('<a class="ipc-metadata-list-summary-item__t" role="button" tabindex="0" aria-disabled="false" href="')[1].split('"')[0]
            response = self.session.get('https://www.imdb.com' + item_found, cookies=self.cookies, headers=self.headers, allow_redirects=True)
            print("Visited the page of the series, now filtering HTML Code...")
            return response.text
        except IndexError:
            time.sleep(1)
            return self.get_item(text, retries + 1)


    def get_trailer(self, text, retries=0):
        if retries == 5:
            return None
        try:
            trailer_found = 'https://www.imdb.com/video/imdb/' + text.split('https://www.imdb.com/video/imdb/')[1].split('"')[0]
            print(f'Trailer found: {trailer_found}')
            return trailer_found
        except IndexError:
            time.sleep(1)
            return self.get_trailer(text, retries + 1)

    def write_to_file(self, query, trailer, file_path):
        with open(file_path, 'a') as file:
            file.write(f'{query} -:- {trailer}\n')

    def workers(self, queryList, output_file_path):
        for query in queryList:
            search_text = self.search_query(query)
            item_text = self.get_item(search_text)
            if item_text is None:
                print(f"Failed to find trailer for: {query}")
                continue
            trailer = self.get_trailer(item_text)
            if trailer is None:
                print(f"Failed to find trailer for: {query}")
                continue
            self.write_to_file(query, trailer, output_file_path)

    def run(self, queries_file_path, output_file_path):
        self.load_queries(queries_file_path)
        num_threads = 10
        chunks = np.array_split(self.queries, num_threads)
        threads = []
        for i in range(num_threads):
            thread = threading.Thread(target=self.workers, args=(chunks[i], output_file_path))
            threads.append(thread)
            thread.start()
        for thread in threads:
            thread.join()

if __name__ == "__main__":
    scraper = Scraper()
    scraper.run('titles.txt', 'trailers.txt')