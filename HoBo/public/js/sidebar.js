const sidebar = document.getElementById('sidebar');

function closeBar() {
    sidebar.style.width = 0;
}

function openBar() {
    sidebar.style.width = '300px';
}

function removeSidebar() {
    if(window.innerWidth >= 1750) {
        closeBar(); 
    }
}

window.addEventListener('resize', removeSidebar);