const sidebar = document.getElementById('sidebar');

const close = document.getElementById('close');

close.style.display = 'none';

function closeBar() {
    sidebar.style.width = '0';
    close.style.display = 'none';
}

function openBar() {
    close.style.display = 'block';
    if (window.innerWidth <= 800) {
        sidebar.style.width = '90%';
    } else if (window.innerWidth <= 1200) {
        sidebar.style.width = '50%';
    } else {
        sidebar.style.width = '300px';
    }
}

function removeSidebar() {
    if(window.innerWidth >= 1750) {
        closeBar(); 
    }
}

window.addEventListener('resize', removeSidebar);