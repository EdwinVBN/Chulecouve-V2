const sidebar = document.getElementById('sidebar');

function closeBar() {
    sidebar.style.width = 0;
}

function openBar() {
    console.log('try');
    sidebar.style.width = '300px';
}