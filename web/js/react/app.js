import Playlist from "playlist.js"
import Player from "player.js"

class AppState {
    static PLAYER_PAUSE = "PAUSE";
    static PLAYER_PLAY = "PLAY";
    static PLAYER_RESUME = "RESUME";
}

export default function App() {
    const [data, _setData] = React.useState({
    });
    const setData = props => {
        let target = {...data, ...props}
//        console.log(target)
        _setData(target)
    }
    const [config, _setConfig] = React.useState({
        level: "root"
    });
    const setConfig = props => {
        let target = {...config, ...props}
        _setConfig(target)
    }
    const [state, setState] = React.useState(AppState.PLAYER_PAUSE);
    const [loading, setLoading] = React.useState(false);
    const [error, setError] = React.useState({});

    React.useEffect(() => {
        fetch("https://player.amgcompany.ru/api/default/welcome", {
            headers: {
                "Authorization": `Bearer ${authKey}`
            },
            mode: "cors"
        }).then(response => response.json()).then(response => {
            if (response.ok) {
                setData(response.data)
            } else {
                setError({code: response.code, message: response.message})
            }
            setLoading(true)
        })
    }, []);

    React.useEffect(() => {
        setConfig(config)
    }, [config.level])

    React.useEffect(() => {
        console.log(data.currentTrack)
    }, [data.currentTrack])

    if (loading) {
        if (Object.keys(error).length) {
            return (
                <div className={"app"}>
                    <div className={"app-error"}>
                        <p className={"error-code"}>{error.code}</p>
                        <p className={"error-message"}>{error.message}</p>
                    </div>
                </div>
            )
        } else {
            switch (config.level) {
                case "root":
                    return (
                        <div className={"app"}>
                            <div className={"playlists row"}>
                                <div className={"col-10 border-right"}>
                                    <Playlist data={{...data, currentPlaylist: {title: "", tracks: data.allTracks}}}
                                              setter={{data: setData, error: setError}} mode={{level: "playlist"}} missingRemove={true}/>
                                </div>
                                <div className={"col-2"}>
                                    <Playlist setter={{data: setData, config: setConfig, error: setError}}
                                              data={data} mode={{level: "root"}}/>
                                </div>
                            </div>
                            <Player playlist={data.currentPlaylist ? data.currentPlaylist : {tracks: data.allTracks}} state="PAUSE" currentTrack={data.currentTrack} />
                        </div>
                    )
                case "playlist":
                    return (
                        <div className={"app"}>
                            <div className={"playlists"}>
                                <header className={"playlist-header"}>
                                    <div></div>
                                    <div className={"playlist-title"}>{data.currentPlaylist ? data.currentPlaylist.title : ""}</div>
                                    <div className={"playlist-close"}>
                                        <i className={"fa-solid fa-times"} onClick={() => {
                                            setConfig({level: "root"})
                                        }} />
                                    </div>
                                </header>
                                <Playlist setter={{data: setData, config: setConfig, error: setError, loading: setLoading}}
                                          data={data} mode={{level: "playlist"}}/>
                            </div>
                            <Player playlist={data.currentPlaylist ? data.currentPlaylist : {tracks: data.allTracks}} state="PAUSE" currentTrack={data.currentTrack} />
                        </div>
                    )
                case "user":
                    return (<></>)
            }
        }
    } else {
        return (
            <div className={"app"}>
                <p className={"app-loading"}>Loading ...</p>
            </div>
        )
    }
}
