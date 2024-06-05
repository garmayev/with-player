const audio = new Audio();

function Player({data, state, setter}) {
    const [current, _setCurrent] = React.useState(data);
    const [status, _setStatus] = React.useState(state);
    const setCurrent = (value) => {
        _setCurrent(value)
        play(value)
    }
    const setStatus = (value) => {
        _setStatus(value)
    }
    function play(value) {
        if ( value ) {
            audio.src = value.url;
        }
        setStatus(AppState.PLAYER_PLAY)
        setter.state(AppState.PLAYER_PLAY)
        audio.play()
    }

    function pause() {
        setStatus(AppState.PLAYER_RESUME)
        setter.state(AppState.PLAYER_RESUME)
        audio.pause()
    }

    function prev() {
        console.log("Prev")
    }

    function next() {
        console.log("Next")
    }

    React.useEffect(() => {
        setCurrent(data)
    }, [data])

    return (<div className="player">
        <div className="player-progress">
            <div className="player-completed"/>
        </div>
        <div className="container">
            <img className="player-thumb" src={current ? current.thumb : ""}/>
            <div className="player-controls">
                <i className="fa-solid fa-backward-step" onClick={prev}/>
                {(status === AppState.PLAYER_PAUSE || status === AppState.PLAYER_RESUME) &&
                    <i className="fa-solid fa-play" onClick={() => {
                        play()
                    }}/>}
                {(status === AppState.PLAYER_PLAY) &&
                    <i className="fa-solid fa-pause" onClick={() => {
                        pause()
                    }}/>}
                <i className="fa-solid fa-forward-step" onClick={next}/>
            </div>
            <div className="player-info"></div>
        </div>
    </div>);
}
