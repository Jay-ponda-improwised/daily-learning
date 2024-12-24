let interval

function restart_timer(handler, args) {
    if (interval) {
        clearInterval(interval)
    }

    let time = 20
    let remaining = document.getElementById('remaining')
    interval = setInterval(() => {
        if (time >= 0) {
            remaining.textContent = time-- + 's'
        } else {
            handler(args)
            clearInterval(interval)
        }
    }, 1000)
}
