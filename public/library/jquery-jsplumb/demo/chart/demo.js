;
(function() {

    jsPlumb.ready(function() {

        var color = "red";
        var instance = jsPlumb.getInstance({
            // notice the 'curviness' argument to this Bezier curve.  the curves on this page are far smoother
            // than the curves on the first demo, which use the default curviness value.			
            Connector: ["Flowchart", {curviness: 100}],
            DragOptions: {cursor: "pointer", zIndex: 2000},
            PaintStyle: {strokeStyle: color, lineWidth: 4},
            EndpointStyle: ["Label", {radius: 0, fillStyle: color}],
            HoverPaintStyle: {strokeStyle: "#ec9f2e"},
            EndpointHoverStyle: {fillStyle: "#ec9f2e"},
            Container: "chart-demo"
        });
        // suspend drawing and initialise.
        instance.doWhileSuspended(function() {
            // declare some common values:
            var arrowCommon = {foldback: 0.0, fillStyle: color, width: 14},
            // use three-arg spec to create two different arrows with the common values:
            overlays = [
                ["PlainArrow", {location: 0.0}, arrowCommon],
                ["Label", {location: 0.0, direction: -1}, arrowCommon]
            ];
            // add endpoints, giving them a UUID.
            // you DO NOT NEED to use this method. You can use your library's selector method.
            // the jsPlumb demos use it so that the code can be shared between all three libraries.
            var windows = jsPlumb.getSelector(".chart-demo .window");
            for (var i = 0; i < windows.length; i++) {
                instance.addEndpoint(windows[i], {
                    uuid: windows[i].getAttribute("id") + "-bottom",
                    anchor: "Bottom",
                    maxConnections: -1
                });
                instance.addEndpoint(windows[i], {
                    uuid: windows[i].getAttribute("id") + "-top",
                    anchor: "Top",
                    maxConnections: -1
                });
            }

            instance.connect({uuids: ["chartWindow1-1-top", "chartWindow2-1-up-bottom"], overlays: overlays});
            instance.connect({uuids: ["chartWindow2-1-up-top", "chartWindow3-1-up-bottom"], overlays: overlays});
            instance.connect({uuids: ["chartWindow2-1-up-top", "chartWindow3-2-up-bottom"], overlays: overlays});
            instance.connect({uuids: ["chartWindow3-1-up-top", "chartWindow4-1-up-bottom"], overlays: overlays});
            instance.connect({uuids: ["chartWindow3-1-up-top", "chartWindow4-2-up-bottom"], overlays: overlays});
            instance.connect({uuids: ["chartWindow3-2-up-top", "chartWindow4-3-up-bottom"], overlays: overlays});
            instance.connect({uuids: ["chartWindow3-2-up-top", "chartWindow4-4-up-bottom"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-1-up-top", "chartWindow5-1-up-bottom"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-1-up-top", "chartWindow5-2-up-bottom"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-2-up-top", "chartWindow5-3-up-bottom"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-2-up-top", "chartWindow5-4-up-bottom"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-3-up-top", "chartWindow5-5-up-bottom"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-3-up-top", "chartWindow5-6-up-bottom"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-4-up-top", "chartWindow5-7-up-bottom"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-4-up-top", "chartWindow5-8-up-bottom"], overlays: overlays});

            instance.connect({uuids: ["chartWindow1-1-bottom", "chartWindow2-1-top"], overlays: overlays});
            instance.connect({uuids: ["chartWindow2-1-bottom", "chartWindow3-1-top"], overlays: overlays});
            instance.connect({uuids: ["chartWindow2-1-bottom", "chartWindow3-2-top"], overlays: overlays});
            instance.connect({uuids: ["chartWindow3-1-bottom", "chartWindow4-1-top"], overlays: overlays});
            instance.connect({uuids: ["chartWindow3-1-bottom", "chartWindow4-2-top"], overlays: overlays});
            instance.connect({uuids: ["chartWindow3-2-bottom", "chartWindow4-3-top"], overlays: overlays});
            instance.connect({uuids: ["chartWindow3-2-bottom", "chartWindow4-4-top"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-1-bottom", "chartWindow5-1-top"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-1-bottom", "chartWindow5-2-top"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-2-bottom", "chartWindow5-3-top"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-2-bottom", "chartWindow5-4-top"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-3-bottom", "chartWindow5-5-top"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-3-bottom", "chartWindow5-6-top"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-4-bottom", "chartWindow5-7-top"], overlays: overlays});
            instance.connect({uuids: ["chartWindow4-4-bottom", "chartWindow5-8-top"], overlays: overlays});
            instance.draggable(windows);
        });
    });
})();