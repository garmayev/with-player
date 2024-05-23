class AppState {
    static PLAYER_PAUSE = "PAUSE";
    static PLAYER_PLAY = "PLAY";
    static PLAYER_RESUME = "RESUME";
}
function App() {
    const [data, _setData] = React.useState({
        currentTrack: {},
        currentPlaylist: [],
        playlists: playlists,
        index: undefined
    });
    const setData = props => {
        let target = {...data, ...props}
        window.localStorage.setItem("data", JSON.stringify(target))
        _setData(target)
    }
    const [config, _setConfig] = React.useState({
        mode: "list",
        stage: "root",
    });
    const setConfig = props => {
        let target = {...config, ...props}
        window.localStorage.setItem("config", JSON.stringify(target))
        _setConfig(target)
    }
    const [state, _setState] = React.useState(AppState.PLAYER_PAUSE);
    const setState = props => {
        _setState(props)
    }
    const [currentTrack, _setCurrentTrack] = React.useState({});
    const setCurrentTrack = props => {
        console.log(props)
        _setCurrentTrack(props)
    }

    React.useEffect(() => {
        let tmpData = JSON.parse(window.localStorage.getItem("data"))
        let tmpConfig = JSON.parse(window.localStorage.getItem("config"))
        if ( tmpData ) {
            tmpData.playlists = [{
                "title": "My Collection",
                "tracks": collection
            }].concat(playlists);
            console.log(tmpData);
        } else {
            tmpData = {
                playlists: [{"title": "My Collection", "tracks": collection}]
            }
        }
        setData(tmpData)
        setConfig(tmpConfig)
    }, []);

    function findTrackById(array, id) {
        let index = -1;
        array.map((item, position) => {
            if (item.id === id) index = position
        })
        return index;
    }
    function setFavorite(item) {
        collection.splice(findTrackById(collection, item.id), 1, item)
        for (const playlist of data.playlists) {
            playlist.splice(findTrackById(playlist, item.id), 1, item)
        }
        allTrack.splice(findTrackById(collection, item.id), 1, item)
        data.playlists.splice(0, 1, {
            title: "My Collection",
            tracks: collection
        })
        setData(data)
    }

    React.useEffect(() => {
        data.currentPlaylist = allTracks;
        setData(data)
    }, [config.stage])

    console.log(allTracks)

    switch (config.stage) {
        case "root":
            return (
                <>
                    <div className={"row"}>
                        <div className={"col-9"}>
                            <Playlist config={{...config, stage: "playlist"}} data={{...data, currentPlaylist: {title: "Free", tracks: allTracks}}}
                                      setter={{data: setData, config: setConfig, state: setState, currentTrack: setCurrentTrack, favorite: setFavorite}} />
                        </div>
                        <div className={"col-3"}>
                            <View className={"col-3"} config={config} data={data} setter={{data: setData, config: setConfig}}>
                                <Playlist config={config} data={data}
                                          setter={{data: setData, config: setConfig, state: setState, currentTrack: setCurrentTrack, favorite: setFavorite}} />
                            </View>
                        </div>
                    </div>
                    <Player data={currentTrack} state={state} setter={{data: setData, config: setConfig, state: setState, favorite: setFavorite}} />
                </>
            )
        case "playlist":
            return (
                <>
                    <View config={config} data={data} setter={{data: setData, config: setConfig}}>
                        <Playlist config={config} data={data}
                                  setter={{data: setData, config: setConfig, state: setState, currentTrack: setCurrentTrack, favorite: setFavorite}} />
                    </View>
                    <Player data={currentTrack} state={state} setter={{data: setData, config: setConfig, state: setState, favorite: setFavorite}} />
                </>
            )
    }
}
