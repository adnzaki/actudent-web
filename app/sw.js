if (!self.define) {
  let e,
    a = {};
  const c = (c, i) => (
    (c = new URL(c + ".js", i).href),
    a[c] ||
      new Promise((a) => {
        if ("document" in self) {
          const e = document.createElement("script");
          (e.src = c), (e.onload = a), document.head.appendChild(e);
        } else (e = c), importScripts(c), a();
      }).then(() => {
        let e = a[c];
        if (!e) throw new Error(`Module ${c} didn’t register its module`);
        return e;
      })
  );
  self.define = (i, n) => {
    const s =
      e ||
      ("document" in self ? document.currentScript.src : "") ||
      location.href;
    if (a[s]) return;
    let f = {};
    const o = (e) => c(e, s),
      b = { module: { uri: s }, exports: f, require: o };
    a[s] = Promise.all(i.map((e) => b[e] || o(e))).then((e) => (n(...e), f));
  };
}
define(["./workbox-330ce1d9"], function (e) {
  "use strict";
  e.setCacheNameDetails({ prefix: "actudent-vite" }),
    self.skipWaiting(),
    e.clientsClaim(),
    e.precacheAndRoute(
      [
        {
          url: "assets/bg-login-dark.435d9299.png",
          revision: "a5c94ebcb57db4e6988178b2009137c6",
        },
        {
          url: "assets/bg-login-light.51846cf1.png",
          revision: "82a536486e594f4b9bf84a65e34b2dbd",
        },
        {
          url: "assets/company-logo.6eb4ff1e.png",
          revision: "3d323ee18057223668bb7df4fc425e80",
        },
        {
          url: "assets/ErrorNotFound.198a10fb.js",
          revision: "337e9f32277698980df5fc282a27bafb",
        },
        {
          url: "assets/flUhRq6tzZclQEJ-Vdg-IuiaDsNa.fd84f88b.woff",
          revision: "3e1afe59fa075c9e04c436606b77f640",
        },
        {
          url: "assets/flUhRq6tzZclQEJ-Vdg-IuiaDsNcIhQ8tQ.4a4dbc62.woff2",
          revision: "a4160421d2605545f69a4cd6cd642902",
        },
        {
          url: "assets/global.25fd8bd2.js",
          revision: "52a75c1a179a1c31dc00f31de5309890",
        },
        {
          url: "assets/gok-H7zzDkdnRel8-DQ6KAXJ69wP1tGnf4ZGhUcel5euIg.35dca8a7.woff2",
          revision: "0ba49c096a77b67734434cebcaf2e14d",
        },
        {
          url: "assets/gok-H7zzDkdnRel8-DQ6KAXJ69wP1tGnf4ZGhUcY.8e94758c.woff",
          revision: "0e4321a7c0dda51d72a669ac5892fc39",
        },
        {
          url: "assets/icon-512x512.fce1c8fd.png",
          revision: "5c2fe427870f28d0a724ca62a9b56d41",
        },
        {
          url: "assets/index.2954a718.js",
          revision: "65e375ec158fb70eef44404aa305b45d",
        },
        {
          url: "assets/index.45374211.css",
          revision: "d50e4c89aca42b1ded1fab19b1b7da79",
        },
        {
          url: "assets/KFOkCnqEu92Fr1MmgVxIIzQ.34e9582c.woff",
          revision: "4aa2e69855e3b83110a251c47fdd05fc",
        },
        {
          url: "assets/KFOlCnqEu92Fr1MmEU9fBBc-.9ce7f3ac.woff",
          revision: "40bcb2b8cc5ed94c4c21d06128e0e532",
        },
        {
          url: "assets/KFOlCnqEu92Fr1MmSU5fBBc-.bf14c7d7.woff",
          revision: "ea60988be8d6faebb4bc2a55b1f76e22",
        },
        {
          url: "assets/KFOlCnqEu92Fr1MmWUlfBBc-.e0fd57c0.woff",
          revision: "0774a8b7ca338dc1aba5a0ec8f2b9454",
        },
        {
          url: "assets/KFOlCnqEu92Fr1MmYUtfBBc-.f6537e32.woff",
          revision: "bcb7c7e2499a055f0e2f93203bdb282b",
        },
        {
          url: "assets/KFOmCnqEu92Fr1Mu4mxM.f2abf7fb.woff",
          revision: "d3907d0ccd03b1134c24d3bcaf05b698",
        },
        {
          url: "assets/Login.e36a41a7.js",
          revision: "be0904c3bc1a3a2cc5958dba4bc590dd",
        },
        {
          url: "assets/MainLayout.44080f30.js",
          revision: "99a6a2e3edcac98882baa423beadd90b",
        },
        {
          url: "assets/QBanner.2ba792f3.js",
          revision: "a7d4719e3b2c49ea1c7f1538613718d2",
        },
        {
          url: "assets/QLayout.84a68525.js",
          revision: "ba52f38de340e5065a208535de196c5f",
        },
        {
          url: "assets/register-component.6164cd89.css",
          revision: "ca12154546f38a935013cbd427ef2aa7",
        },
        {
          url: "assets/register-component.977a5f75.js",
          revision: "cb4346fff40318bb8952d3535772f2a8",
        },
        {
          url: "assets/SetupPage.20ff0a9b.css",
          revision: "dc1c1dcf7844f27549a210da2e08aa01",
        },
        {
          url: "assets/SetupPage.99f8f3af.js",
          revision: "fc3756b7fd440e5ea1f30c383d509c91",
        },
        {
          url: "bg-login-dark.png",
          revision: "a5c94ebcb57db4e6988178b2009137c6",
        },
        {
          url: "bg-login-light.png",
          revision: "82a536486e594f4b9bf84a65e34b2dbd",
        },
        { url: "bg-login.ai", revision: "ed6001e2959b0c394e827f319cc186ac" },
        { url: "bg-login.png", revision: "c3f66166113f0f5946a4f4ba5c687b30" },
        { url: "boy-avatar.png", revision: "5ff53af98c1baed764f833b67847d2b1" },
        {
          url: "company-logo.ai",
          revision: "a37de792977e9b64f6842b40f9412dd7",
        },
        {
          url: "company-logo.png",
          revision: "3d323ee18057223668bb7df4fc425e80",
        },
        { url: "favicon.ico", revision: "2f145b97f453ce8790650d03e571e973" },
        {
          url: "icons/apple-icon-120x120.png",
          revision: "30691a15f75926805dea680102c17383",
        },
        {
          url: "icons/apple-icon-152x152.png",
          revision: "f5ea17de4066139fe98e59d3f957926c",
        },
        {
          url: "icons/apple-icon-167x167.png",
          revision: "d90df60a59291ffe48fff536cceea15c",
        },
        {
          url: "icons/apple-icon-180x180.png",
          revision: "5b3b5eb9c7b4ba86b6e91a38388bf796",
        },
        {
          url: "icons/apple-launch-1125x2436.png",
          revision: "a0bcdf43b1934983a6c66cf470c0b4b5",
        },
        {
          url: "icons/apple-launch-1170x2532.png",
          revision: "a7e55be8f79eac3f4469bbc6aa621590",
        },
        {
          url: "icons/apple-launch-1242x2208.png",
          revision: "a23f530832087820d125e7ed823e3a7c",
        },
        {
          url: "icons/apple-launch-1242x2688.png",
          revision: "8a98a666997ea42cc21f09fda4a8d9dd",
        },
        {
          url: "icons/apple-launch-1284x2778.png",
          revision: "5e835cd144615da5adfc4b9caab4bc5d",
        },
        {
          url: "icons/apple-launch-1536x2048.png",
          revision: "b8fcd2bf25e615b5a7f5cd757b507817",
        },
        {
          url: "icons/apple-launch-1620x2160.png",
          revision: "1f5d16e6014b3b503bb28cd1f0281bd9",
        },
        {
          url: "icons/apple-launch-1668x2224.png",
          revision: "362834ecbef011e1ade7a58ad50b4a70",
        },
        {
          url: "icons/apple-launch-1668x2388.png",
          revision: "2eb64178d1c82633567610970ec320df",
        },
        {
          url: "icons/apple-launch-2048x2732.png",
          revision: "4bc1932ad258ba6e14cef498795ac96d",
        },
        {
          url: "icons/apple-launch-750x1334.png",
          revision: "e2abe046410959af45ec9a60119d2a09",
        },
        {
          url: "icons/apple-launch-828x1792.png",
          revision: "8c42c7a37320b0a1dae30e08e09324e4",
        },
        {
          url: "icons/favicon-128x128.png",
          revision: "cf3f761ff2c7b454f3bcb0e926a3c75c",
        },
        {
          url: "icons/favicon-16x16.png",
          revision: "82d1883a360e63795f470f63b173c46f",
        },
        {
          url: "icons/favicon-32x32.png",
          revision: "48af2101133b24b4108327a7b3d0e13c",
        },
        {
          url: "icons/favicon-96x96.png",
          revision: "795e59c8836aaf48e3af636943c2f294",
        },
        {
          url: "icons/icon-128x128.png",
          revision: "cf3f761ff2c7b454f3bcb0e926a3c75c",
        },
        {
          url: "icons/icon-192x192.png",
          revision: "452bd938ab608ae9c5178b56f8707433",
        },
        {
          url: "icons/icon-256x256.png",
          revision: "0e25a22620c885f545afbb925d368ed8",
        },
        {
          url: "icons/icon-384x384.png",
          revision: "b584b49cb92fa7a053843b2ca526a69a",
        },
        {
          url: "icons/icon-512x512.png",
          revision: "5c2fe427870f28d0a724ca62a9b56d41",
        },
        {
          url: "icons/ms-icon-144x144.png",
          revision: "aa226b5f8f6019bd8b7d8b5b62176cb6",
        },
        {
          url: "icons/safari-pinned-tab.svg",
          revision: "f673a6d2cbe6b44c19e9ef8f72b279ac",
        },
        { url: "index.html", revision: "7c6dd33ed99c7ffc32b22fbe6625d0e1" },
        {
          url: "LOGO-WOLES-white-small.png",
          revision: "1018d9791bdef85d584b2760db9802c4",
        },
        { url: "manifest.json", revision: "e2f852794dac0a9bb95233bcb2718bad" },
        { url: "no-image.png", revision: "8dffe4b346d976364b1ddf9b8c8a7dec" },
        {
          url: "siabsen-logo-icon.png",
          revision: "9d2a9aa088e82abaec8a6b7a60e37d70",
        },
        {
          url: "siabsen-logo-white.png",
          revision: "9f383e8d01303c2ec497215036602edd",
        },
        {
          url: "siabsen-logo.png",
          revision: "edde2b0cbc81275a4c9bcc4c30b69d46",
        },
      ],
      {}
    ),
    e.cleanupOutdatedCaches(),
    e.registerRoute(
      new e.NavigationRoute(e.createHandlerBoundToURL("index.html"), {
        denylist: [/sw\.js$/, /workbox-(.)*\.js$/],
      })
    );
});
