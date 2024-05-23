function Playlist({parentState, current, data, setter, config, player}) {
    const [tracks, setTracks] = React.useState(data.currentPlaylist.tracks);

    function play(value) {
        setter.data({currentTrack: value})
        setter.currentTrack(value)
    }
    function findTrackById(array, id) {
        let index = -1;
        array.map((item, position) => {
            if (item.id === id) index = position
        })
        return index;
    }
    function toggleFavorite(id, event) {
        let indexInCurrentPlaylist = findTrackById(tracks, id)
        let track = tracks[indexInCurrentPlaylist];
        event.target.classList.remove("fa-heart");
        event.target.classList.add("fa-solid");
        event.target.classList.add("fa-spinner");
        if (event.target.classList.contains("fa-regular")) {
            event.target.classList.remove("fa-regular");
        }
        fetch(`https://garmayev.local/api/track/favorite?id=${id}`)
            .then(response => response.json())
            .then(response => {
                if (response.ok) {
                    setter.favorite(response.data)
                    if ( response.data.favorite !== 1 ) {
                        event.target.classList.remove("fa-solid");
                        event.target.classList.add("fa-regular");
                    }
                    event.target.classList.remove("fa-spinner");
                    event.target.classList.add("fa-heart");
                }
            })
            .catch(error => {
                event.target.classList.add("fa-heart");
                event.target.classList.remove("fa-spinner");
                console.error(error)
            })
    }

    if (config.stage === "playlist") {
        let trackList = tracks.map((item, index) => {
            switch (config.mode) {
                case "list":
                    let minutes = Math.floor(item.length / 60),
                        seconds = item.length % 60
                    return (
                        <li key={index} className='track'
                            data-state={(current === item && parentState === STATE_PLAY) ? "active" : ""}>
                            <img src={item.thumb} className="track-thumb" onClick={() => play(item)}/>
                            <div className="track-info" onClick={() => play(item)}>
                                <p className="track-title">{item.title}</p>
                                <p className="track-artist">{item.artists && item.artists.map(artist => artist.name).join(", ")}</p>
                            </div>
                            <div className="track-controls">
                                {item.favorite ? <i className="fa-solid fa-heart" onClick={(event) => toggleFavorite(item.id, event)}/> :
                                    <i className="fa-regular fa-heart" onClick={(event) => toggleFavorite(item.id, event)}/>}
                                <i className="fa-regular fa-plus"/>
                            </div>
                            <p className="track-length">{minutes}:{seconds}</p>
                        </li>)
                case "row":
                    return (
                        <li key={index} className="track" style={{backgroundImage: `url(${item.thumb})`}}
                            data-state={(current === item && parentState === STATE_PLAY) ? "active" : ""}>
                            <div className="track-info" onClick={() => play(item)}>
                                <p className="track-title">{item.title}</p>
                                <p className="track-artist">{item.artists && item.artists.join(", ")}</p>
                            </div>
                        </li>)
            }
        })
        return (<ul data-state={config.mode} className="playlist">{trackList}</ul>);
    } else {
        let playlists = data.playlists.map((item, index) => (<p key={index} onClick={() => {
            setter.data({...data, currentPlaylist: item})
            setter.config({...config, stage: "playlist"})
        }}>{item.title}</p>))
        return (<>{playlists}</>)
    }
}
