function updateSpan() {
    var inputValue = document.getElementById('shard_code').value;
    document.getElementById('showingShardCode').innerText = inputValue;
}

$(document).ready(() => {
    updateSpan();
});