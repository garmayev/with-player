function Playlist({setter, mode, data}) {
    const [playlist, setPlaylist] = React.useState(data.currentPlaylist ?? {});

    function findElementById(id) {
        for (const key in playlist) {
            if (Number.parseInt(playlist[key].id) === Number.parseInt(id)) {
                return playlist[key]
            }
        }
    }

    function findPlaylist(id) {
        for (const key in data.myPlaylists) {
            if (data.myPlaylists[key].id === id) {
                return data
            }
        }
    }

    function appendToPlaylist(playlist, event) {
        let trackId = event.target.closest(".track").getAttribute("data-key")
        fetch(`https://garmayev.local/api/track/add-to-playlist?playlist_id=${playlist.id}&track_id=${trackId}`)
            .then(response => response.json())
            .then(response => {
                let track = findElementById(trackId)
                if (!response.ok) {
                    setter.error({code: response.code, message: response.message})
                } else {
                    playlist.tracks.push(track)
                    for (const key in data.myPlaylists) {
                        if (data.myPlaylists[key].id === playlist.id) {
                            data.myPlaylists[key] = playlist
                        }
                    }
                    setter.data({myPlaylists: data.myPlaylists, currentPlaylist: playlist})
                }
            })
            .catch(error => {
                setter.error(error)
            })
    }

    function removeFromPlaylist(event) {
        let trackId = event.target.closest(".track").getAttribute("data-key"),
            track = event.target.closest(".track")
        fetch(`https://garmayev.local/api/track/remove-from-playlist?playlist_id=${playlist.id}&track_id=${trackId}`)
            .then(response => response.json())
            .then(response => {
                if (!response.ok) {
                    setter.error({code: response.code, message: response.message})
                } else {
                    for (let i = 0; i < playlist.tracks.length; i++) {
                        let track = playlist.tracks[i];
                        if (track.id === trackId) {
                            playlist.splice(i, 1)
                        }
                    }
                    for (const key in data.myPlaylists) {
                        if (data.myPlaylists[key].id === playlist.id) {
                            data.myPlaylists[key] = playlist
                        }
                    }
                    track.remove()
                    setter.data({myPlaylists: data.myPlaylists, currentPlaylist: playlist})
                }
            })
            .catch(error => {
                setter.error(error)
            })
    }

    function changePlaylist(e, playlist) {
        if (setter.config) {
            setter.data({currentPlaylist: playlist})
            setter.config({level: "playlist"})
        }
    }

    function toggleLike(event, track) {
        fetch(`https://garmayev.local/api/track/favorite?id=${track.id}`)
            .then(response => response.json())
            .then(response => {
                if (response.ok) {
                    if (response.data.favorite) {
                        event.target.classList.remove(...event.target.classList)
                        event.target.classList.add("fa-solid")
                        event.target.classList.add("fa-heart")
                    } else {
                        event.target.classList.remove(...event.target.classList)
                        event.target.classList.add("fa-regular")
                        event.target.classList.add("fa-heart")
                    }
                } else {
                    setter.error(response)
                }
            })
            .catch(error => {
                setter.error(error)
            })
    }

    switch (mode.level) {
        case "root":
            let list1 = data.myPlaylists.map((item, index) =>
                <div key={index}>
                    <a href={"#"} onClick={(e) => changePlaylist(e, item)} className={"submit"}>{item.title}</a>
                </div>
            )
            return (<>{list1}</>)
        case "playlist":
            let buttons = data.myPlaylists.map((item, index) => {
                if (index !== 0) {
                    return (
                        <li key={index}>
                            <a className="dropdown-item" href="#"
                               onClick={(event) => appendToPlaylist(item, event)}>{item.title}</a>
                        </li>
                    )
                }
            })
            buttons.push(
                <li key={999}>
                    <a className={"dropdown-item"} href={"#"} onClick={(event) => removeFromPlaylist(event)}>Remove from
                        current playlist</a>
                </li>
            )
            let list2;
            if (playlist.tracks) {
                list2 = playlist.tracks.map((item, index) => {
                    let minutes = Math.floor(item.length / 60);
                    let seconds = item.length % 60;
                    return (
                        <div className={"track row mb-1"} key={index} data-key={item.id}>
                            <div className={"track-thumb col-1"}>
                                <img src={item.thumb ?? "/img/none.png"} alt={item.title}/>
                            </div>
                            <div className={"track-info col-9 d-flex"}>
                                <p className={"track-title"}>{item.title}</p>
                                <p className={"track-artist"}>{item.artists.map(artist => artist.name).join(", ")}</p>
                            </div>
                            <div className={"track-length col-1 d-flex"}>
                                <span>{minutes}:{seconds}</span>
                            </div>
                            <div className={"track-controls col-1 d-flex"}>
                                {item.favorite ?
                                    <i className={"fa-solid fa-heart"} onClick={(e) => toggleLike(e, item)}/> :
                                    <i className={"fa-regular fa-heart"} onClick={(e) => toggleLike(e, item)}/>}
                                <div className="btn-group">
                                    <button type="button" className="btn btn-default dropdown-toggle"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i className={"fa-solid fa-ellipsis-vertical"}/>
                                    </button>
                                    <ul className="dropdown-menu">
                                        {buttons}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    )
                })
            } else {
                list2 = playlist.map((item, index) => {
                    let minutes = Math.floor(item.length / 60);
                    let seconds = item.length % 60;
                    return (
                        <div className={"track row mb-1"} key={index} data-key={item.id}>
                            <div className={"track-thumb col-1"}>
                                <img src={item.thumb ?? "/img/none.png"} alt={item.title}/>
                            </div>
                            <div className={"track-info col-9 d-flex"}>
                                <p className={"track-title"}>{item.title}</p>
                                <p className={"track-artist"}>{item.artists.map(artist => artist.name).join(", ")}</p>
                            </div>
                            <div className={"track-length col-1 d-flex"}>
                                <span>{minutes}:{seconds}</span>
                            </div>
                            <div className={"track-controls col-1"}>
                                <div className="btn-group">
                                    <button type="button" className="btn btn-default dropdown-toggle"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i className={"fa-solid fa-ellipsis-vertical"}/>
                                    </button>
                                    <ul className="dropdown-menu">
                                        {buttons}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    )
                })
            }

            return (
                <div className={"tracks"}>{list2}</div>
            )
    }
}
