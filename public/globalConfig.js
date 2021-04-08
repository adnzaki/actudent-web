const mode = 'build' // development, build, production

const baseUrl = () => {
    return (mode !== 'production')
            ? `http://${window.location.hostname}/actudent/public/`
            : `https://${window.location.hostname}/public/`
}

export { mode, baseUrl }