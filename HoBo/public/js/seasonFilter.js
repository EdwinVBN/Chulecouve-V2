const select = document.getElementById('seasons');
const options = document.querySelectorAll('.seasonOptions');

function getEpisodes() {
    const selectValue = select.value;

    options.forEach(option => {
        let season = option.getAttribute('data-value').charAt(12);
        option.setAttribute("index", season);
        

        if(option.getAttribute('index') != selectValue) {
            option.style.width = '0px';
            option.style.display = 'none';
        } else {
            option.style.width = '235px';
            option.style.display = 'inline-block';
        }
        
    })
}

select.addEventListener('change', getEpisodes);
window.addEventListener('load', getEpisodes);
