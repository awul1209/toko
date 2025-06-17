(function () {
  'use strict';

  L.Routing.GraphHopper = L.Class.extend({
    options: {
      serviceUrl: 'https://graphhopper.com/api/1/route',
      timeout: 30 * 1000,
      urlParameters: {},
      vehicle: 'car',
      unitSystem: L.Routing.ItineraryBuilder.prototype.options.unitSystem
    },

    initialize: function (apiKey, options) {
      L.Util.setOptions(this, options);
      this._apiKey = apiKey;
    },

    route: function (waypoints, callback, context, options) {
      var timedOut = false;
      var timer = setTimeout(function () {
        timedOut = true;
        callback.call(context || callback, {
          status: -1,
          message: 'GraphHopper request timed out.'
        });
      }, this.options.timeout);

      var url = this.buildRouteUrl(waypoints);

      fetch(url)
        .then((res) => res.json())
        .then((data) => {
          clearTimeout(timer);
          if (!timedOut) {
            if (!data.paths || data.paths.length === 0) {
              callback.call(context || callback, {
                status: -1,
                message: 'No route found.'
              });
              return;
            }
            var coordinates = data.paths[0].points.coordinates.map(function (c) {
              return L.latLng(c[1], c[0]);
            });
            var summary = {
              totalDistance: data.paths[0].distance,
              totalTime: data.paths[0].time
            };
            callback.call(context || callback, null, [{
              name: '',
              coordinates: coordinates,
              summary: summary,
              instructions: [],
              inputWaypoints: waypoints,
              actualWaypoints: waypoints
            }]);
          }
        })
        .catch(function (err) {
          clearTimeout(timer);
          if (!timedOut) {
            callback.call(context || callback, {
              status: -1,
              message: err.message
            });
          }
        });
    },

    buildRouteUrl: function (waypoints) {
      var locs = [],
        i;
      for (i = 0; i < waypoints.length; i++) {
        locs.push('point=' + waypoints[i].latLng.lat + ',' + waypoints[i].latLng.lng);
      }

      var url = this.options.serviceUrl + '?' + locs.join('&');
      url += '&vehicle=' + this.options.vehicle;
      url += '&key=' + this._apiKey;
      url += '&points_encoded=false&instructions=false&type=json';

      for (var key in this.options.urlParameters) {
        url += '&' + key + '=' + this.options.urlParameters[key];
      }

      return url;
    }
  });

  L.Routing.graphHopper = function (apiKey, options) {
    return new L.Routing.GraphHopper(apiKey, options);
  };
})();
