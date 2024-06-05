const audio = new Audio();

class AppState {
    static PLAYER_PAUSE = "PAUSE";
    static PLAYER_PLAY = "PLAY";
    static PLAYER_RESUME = "RESUME";
}

export default function Player({data, state, setter, playlist, currentTrack}) {
    const [current, _setCurrent] = React.useState(currentTrack);
    const [index, setIndex] = React.useState(0);
    const [status, _setStatus] = React.useState(state);
    const setCurrent = (value) => {
        _setCurrent(value)
        play(value)
    }
    const setStatus = (value) => {
        _setStatus(value)
    }
    React.useEffect((e) => {
        if ( currentTrack ) {
            setCurrent(currentTrack)
        }
    }, [currentTrack])
    function play(value) {
        if ( status == "RESUME" ) {
            setStatus("PLAY")
            audio.play()
            return
        }
        if ( value ) {
            audio.src = value.url;
        } else {
            audio.src = playlist.tracks[index].url
        }
        setStatus("PLAY")
//        setter.state(AppState.PLAYER_PLAY)
        audio.play()
    }

    function pause() {
        setStatus(AppState.PLAYER_RESUME)
//        setter.state(AppState.PLAYER_RESUME)
        audio.pause()
    }

    function prev() {
        if ( index > 0 ) {
            setIndex( index - 1 )
        } else {
            setIndex( playlist.length - 1 )
        }
        setCurrent( playlist.tracks[index - 1] )
    }

    function next() {
        if ( index < playlist.tracks.length - 1 ) {
            setIndex(index + 1)
        } else {
            setIndex( 0 )
        }
        setCurrent( playlist.tracks[index + 1] )
    }

    return (<div className="player">
        <div className="player-progress">
            <div className="player-completed"/>
        </div>
        <div className="container">
            <div className="player-thumb">
                <img src={current ? current.thumb : ""} alt={current ? current.title : ""} className={"image"} />
            </div>
            <div className="player-controls">
                <i className="fa-solid fa-backward-step" onClick={prev}/>
                {(status === "PAUSE" || status === "RESUME") &&
                    <i className="fa-solid fa-play" onClick={() => {
                        play()
                        setStatus("PLAY")
                    }}/>}
                {(status === "PLAY") &&
                    <i className="fa-solid fa-pause" onClick={() => {
                        pause()
                        setStatus("RESUME")
                    }}/>}
                <i className="fa-solid fa-forward-step" onClick={next}/>
            </div>
            <div className="player-info"></div>
        </div>
    </div>);
}
