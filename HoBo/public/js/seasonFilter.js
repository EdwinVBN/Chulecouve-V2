const select = document.getElementById('seasons');
const options = document.querySelectorAll('.seasonOptions');

function getEpisodes() {
    const selectValue = select.value;

    options.forEach(option => {
        let season = option.getAttribute('data-value').match(/S(\d+)E/)[1];
        option.setAttribute("index", season);
        

        if(option.getAttribute('index') != selectValue) {
            option.style.width = '0px';
            option.style.display = 'none';
        } else {
            option.style.width = '235px';
            option.style.display = 'inline-block';
        }
        
    })

    // Adjust carousel width
    const carouselImages = document.querySelector('.carousel-images');
    const visibleOptions = document.querySelectorAll('.seasonOptions[style*="inline-block"]');
    carouselImages.style.width = `${visibleOptions.length * 265}px`; // Adjust width based on visible items
}

select.addEventListener('change', getEpisodes);