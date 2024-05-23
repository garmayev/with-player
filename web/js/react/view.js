function View({config, data, setter, children}) {
    const [mode, _setMode] = React.useState("row");
    const setMode = value => {
        setter.config({...config, mode: value})
        config.mode = value
        _setMode(value)
    }

    return (
        <>
            { config.stage !== "root" &&
                <div className={"view-header"}>
                    <div>
                        <div className="btn-group">
                            <button type="button" className="btn dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                {mode}
                            </button>
                            <ul className="dropdown-menu">
                                <li>
                                    {mode === "row" ?
                                        <a className="dropdown-item active">Row</a> :
                                        <a className="dropdown-item" onClick={() => setMode("row")}>Row</a>
                                    }
                                </li>
                                <li>
                                    {mode === "list" ?
                                        <a className="dropdown-item active">List</a> :
                                        <a className="dropdown-item" onClick={() => setMode("list")}>List</a>
                                    }
                                </li>
                            </ul>
                        </div>
                    </div>
                    {data.currentPlaylist && <h1>{data.currentPlaylist.title}</h1>}
                    <div className="btn" onClick={() => {
                        setter.config({...config, stage: "root"})
                        setter.data({...data, currentPlaylist: {}})
                    }}>
                        <i className={"fa-solid fa-times"}></i>
                    </div>
                </div>
            }
            {children}
        </>
    )
}
