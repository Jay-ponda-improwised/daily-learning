async function addNewKey(event) {
    console.log("clicked");
    event.preventDefault();
    document.getElementById('submit').disabled = true;
    id = document.getElementById('id').value;
    key = document.getElementById('key').value;
    value = document.getElementById('value').value;

        const response = await fetch('/redis/' + document.getElementById('id').value + '/upsert/' + document.getElementById('key').value, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                value: value
            })
        });
        console.log(await response.json());


    document.getElementById('submit').disabled = false;

}

async function confirm(event) {
    event.preventDefault();
    document.getElementById('submit').disabled = true;
    id = document.getElementById('id').value;
    key = document.getElementById('key').value;

    const response = await fetch(`/redis/${id}/get/${key}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });
    const jsonResponse = await response.json();
    document.getElementById('value').value = jsonResponse.value ?? '';
    document.getElementById('submit').disabled = false;
}

async function refresh(event) {
    event.preventDefault();
    document.getElementById('submit').disabled = true;
    id = document.getElementById('id').value;

    const response = await fetch(`/redis/${id}/all/`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });
    updateTable(await response.json());
    document.getElementById('submit').disabled = false;
}

async function updateTable(data){
    const table = document.getElementById('table').getElementsByTagName('tbody')[0];
    while (table.hasChildNodes()) {
        table.removeChild(table.lastChild);
    }
    count = 1;
    for (const key in data) {
        if (Object.hasOwnProperty.call(data, key)) {
            const value = data[key];
            const row = table.insertRow();
            const cell1 = row.insertCell(0);
            const cell2 = row.insertCell(1);
            const cell3 = row.insertCell(2);

            cell1.appendChild(document.createTextNode(count));
            cell2.appendChild(document.createTextNode(key));
            cell3.appendChild(document.createTextNode(value));
        }
        count++;
    }
}

document.getElementById('refresh').addEventListener('click', refresh);
document.getElementById('confirm').addEventListener('click', confirm);
