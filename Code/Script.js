function toggleKeyField() {
    const algorithm = document.getElementById('algorithm').value;
    const keyContainer = document.getElementById('keyContainer');
    
    if (algorithm === 'vigenere') {
        keyContainer.style.display = 'block';
        document.getElementById('key').required = true;
    } else {
        keyContainer.style.display = 'none';
        document.getElementById('key').required = false;
    }
}