alert("this is something");

async function addNewKey(event) {
    event.preventDefault();
    document.getElementById('submit').disabled = true;
    const response = await fetch('/redis/' + document.getElementById('id').value + '/upsert/' + document.getElementById('key').value, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            value: document.getElementById('value').value
        })
    });
    document.getElementById('submit').disabled = false;
}
