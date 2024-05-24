class AppState {
    static PLAYER_PAUSE = "PAUSE";
    static PLAYER_PLAY = "PLAY";
    static PLAYER_RESUME = "RESUME";
}

function App() {
    const [data, _setData] = React.useState({
    });
    const setData = props => {
        let target = {...data, ...props}
        _setData(target)
    }
    const [config, _setConfig] = React.useState({
        level: "root"
    });
    const setConfig = props => {
        let target = {...config, ...props}
        _setConfig(target)
    }
    const [loading, setLoading] = React.useState(false);
    const [error, setError] = React.useState({});

    React.useEffect(() => {
        let timer = setInterval(() => {
            fetch("https://garmayev.local/api/default/welcome", {
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
        }, 5000);

        return () => clearInterval(timer);
    }, []);

    React.useEffect(() => {
        setConfig(config)
    }, [config.level])

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
                                              setter={{data: setData, error: setError}} mode={{level: "playlist"}}/>
                                </div>
                                <div className={"col-2"}>
                                    <Playlist setter={{data: setData, config: setConfig, error: setError}}
                                              data={data} mode={{level: "root"}}/>
                                </div>
                            </div>
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
