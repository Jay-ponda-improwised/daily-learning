async function addNewKey(event) {
    console.log("clicked");
    event.preventDefault();
    document.getElementById('submit').disabled = true;

    if(document.getElementById('value').value === '' && document.getElementById('key').value && document.getElementById('id').value){
        const response = await fetch('/redis/' + document.getElementById('id').value + '/get/' + document.getElementById('key').value, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        console.log(await response.json());

    } else {
        const response = await fetch('/redis/' + document.getElementById('id').value + '/upsert/' + document.getElementById('key').value, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                value: document.getElementById('value').value
            })
        });
        console.log(await response.json());

    }

    document.getElementById('submit').disabled = false;
    console.log('/redis/' + document.getElementById('id').value + '/upsert/' + document.getElementById('key').value);

}
