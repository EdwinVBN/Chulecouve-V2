const data = {
	"table": "serie",
	"rows": 
	[
		{
			"SerieId": 1
		},
		{
			"SerieId": 2
		},
		{
			"SerieId": 3
		},
		{
			"SerieId": 4
		},
		{
			"SerieId": 5
		},
		{
			"SerieId": 6
		},
		{
			"SerieId": 11
		},
		{
			"SerieId": 32
		},
		{
			"SerieId": 33
		},
		{
			"SerieId": 34
		},
		{
			"SerieId": 35
		},
		{
			"SerieId": 36
		},
		{
			"SerieId": 44
		},
		{
			"SerieId": 46
		},
		{
			"SerieId": 48
		},
		{
			"SerieId": 64
		},
		{
			"SerieId": 65
		},
		{
			"SerieId": 66
		},
		{
			"SerieId": 69
		},
		{
			"SerieId": 72
		},
		{
			"SerieId": 74
		},
		{
			"SerieId": 76
		},
		{
			"SerieId": 77
		},
		{
			"SerieId": 127
		},
		{
			"SerieId": 156
		},
		{
			"SerieId": 161
		},
		{
			"SerieId": 162
		},
		{
			"SerieId": 210
		},
		{
			"SerieId": 211
		},
		{
			"SerieId": 212
		},
		{
			"SerieId": 213
		},
		{
			"SerieId": 214
		},
		{
			"SerieId": 215
		},
		{
			"SerieId": 216
		},
		{
			"SerieId": 217
		},
		{
			"SerieId": 218
		},
		{
			"SerieId": 220
		},
		{
			"SerieId": 222
		},
		{
			"SerieId": 223
		},
		{
			"SerieId": 224
		},
		{
			"SerieId": 225
		},
		{
			"SerieId": 228
		},
		{
			"SerieId": 229
		},
		{
			"SerieId": 232
		},
		{
			"SerieId": 234
		},
		{
			"SerieId": 236
		},
		{
			"SerieId": 252
		},
		{
			"SerieId": 253
		},
		{
			"SerieId": 254
		},
		{
			"SerieId": 256
		},
		{
			"SerieId": 257
		},
		{
			"SerieId": 260
		},
		{
			"SerieId": 262
		},
		{
			"SerieId": 265
		},
		{
			"SerieId": 266
		},
		{
			"SerieId": 269
		},
		{
			"SerieId": 276
		},
		{
			"SerieId": 278
		},
		{
			"SerieId": 315
		},
		{
			"SerieId": 322
		},
		{
			"SerieId": 325
		},
		{
			"SerieId": 328
		},
		{
			"SerieId": 343
		},
		{
			"SerieId": 356
		},
		{
			"SerieId": 370
		},
		{
			"SerieId": 377
		},
		{
			"SerieId": 379
		},
		{
			"SerieId": 380
		},
		{
			"SerieId": 383
		},
		{
			"SerieId": 385
		},
		{
			"SerieId": 388
		},
		{
			"SerieId": 389
		},
		{
			"SerieId": 392
		},
		{
			"SerieId": 396
		},
		{
			"SerieId": 397
		},
		{
			"SerieId": 401
		},
		{
			"SerieId": 407
		},
		{
			"SerieId": 430
		},
		{
			"SerieId": 493
		},
		{
			"SerieId": 497
		},
		{
			"SerieId": 499
		},
		{
			"SerieId": 517
		},
		{
			"SerieId": 518
		},
		{
			"SerieId": 519
		},
		{
			"SerieId": 521
		},
		{
			"SerieId": 522
		},
		{
			"SerieId": 523
		},
		{
			"SerieId": 529
		},
		{
			"SerieId": 531
		},
		{
			"SerieId": 539
		},
		{
			"SerieId": 541
		},
		{
			"SerieId": 542
		},
		{
			"SerieId": 568
		},
		{
			"SerieId": 581
		},
		{
			"SerieId": 596
		},
		{
			"SerieId": 602
		},
		{
			"SerieId": 604
		}
	]
}

document.addEventListener('DOMContentLoaded', function() {
    const microphoneBtn = document.getElementById('microphoneBtn');
    const searchInput = document.getElementById('searchInput');
    const recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = 'en-US';
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;

    recognition.start();

    microphoneBtn.addEventListener('click', function() {
        if (recognition.isStarted) {
            recognition.stop();
        } else {
            recognition.start();
        }
    });

    recognition.onresult = function(event) {
		const transcript = event.results[event.results.length - 1][0].transcript.toLowerCase();
		console.log(transcript);
	
		if (handleCommand(transcript, 'search for', handleSearch)) return;
		if (handleCommand(transcript, 'to the homepage', handleHome)) return;
		if (handleCommand(transcript, 'watch the', handleWatch)) return;
		if (handleCommand(transcript, 'a random', handleWatchRandom)) return;
	};
	
	function handleCommand(transcript, command, callback) {
		const commandIndex = transcript.indexOf(command);
		if (commandIndex !== -1) {
			callback(transcript, command, commandIndex);
			return true;
		}
		return false;
	}
	
	function handleSearch(transcript, command, commandIndex) {
		const query = transcript.slice(commandIndex + command.length).trim();
		searchInput.value = query;
		setTimeout(() => document.getElementById('searchForm').submit(), 500);
	}
	
	function handleHome() {
		window.location.href = '/';
	}
	
	function handleWatch(transcript, command, commandIndex) {
		const numberWords = ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth'];
		const numberIndex = numberWords.findIndex(word => transcript.includes(word));
		const carouselSections = document.querySelectorAll('.carousel-section');
		if (numberIndex !== -1 && carouselSections[numberIndex]) {
			const link = carouselSections[numberIndex].querySelector('a');
			if (link) {
				window.location.href = link.href.replace('filminfo', 'stream');
			}
		}
	}
	
	function handleWatchRandom() {
		const randomIndex = Math.floor(Math.random() * data.rows.length);
		const randomSerieId = data.rows[randomIndex].SerieId;
		window.location.href = `/stream/${randomSerieId}`;
	}
	

    recognition.onstart = function() {
        recognition.isStarted = true;
        microphoneBtn.classList.add('active');
    };

    recognition.onend = function() {
        recognition.isStarted = false;
        microphoneBtn.classList.remove('active');
        setTimeout(function() {
            recognition.start();
        }, 1000);
    };
});