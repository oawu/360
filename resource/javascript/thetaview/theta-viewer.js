(function() {
  var ThetaViewer;

  ThetaViewer = (function() {
    function ThetaViewer(dom, callback, position, color, d, distance) {
      var _oldHeight, _oldWidth;
      this.init = false;
      this.timer = null;
      this.dom = dom;
      if (!d) {
        this.__defineGetter__('width', function() {
          return Math.min (this.dom.clientWidth, this.dom.clientHeight);
        });
        this.__defineGetter__('height', function() {
          return Math.min (this.dom.clientWidth, this.dom.clientHeight);
        });
      } else {
        this.__defineGetter__('width', function() {
          return Math.max (this.dom.clientWidth, this.dom.clientHeight);
        });
        this.__defineGetter__('height', function() {
          return Math.max (this.dom.clientWidth, this.dom.clientHeight);
        });
      }
      this.images = [];
      this.interval = 1000;
      this.materialOffset = 0;
      this.camera = new THREE.PerspectiveCamera(100, this.width / this.height);
      this.camera.position.set(0, 0, 180);
      this.scene = new THREE.Scene();
      this.renderer = new THREE.WebGLRenderer({
        preserveDrawingBuffer: true
      });

      this.renderer.setClearColor(color ? parseInt (color, 16) : 0xffffff, 0);
      this.renderer.setSize(this.width, this.height);
      this.dom.appendChild(this.renderer.domElement);
      this.controls = new THREE.OrbitControls(this.camera, dom, distance);
      this.controls.addEventListener('change', (function(_this) {
        return function() {
          if (callback) {
            if (!_this.init) {
              clearTimeout (_this.timer);
              _this.timer = setTimeout (function () {
                callback (_this.camera.position);
              }, 500);
            }
          }

          _this.init = false;
          return _this.renderer.render(_this.scene, _this.camera);
        };
      })(this));
      if (position) {
        this.init = true;
        this.camera.position.set (position.x, position.y, position.z);
        this.controls.update ();
      }

      this.sphere = new THREE.SphereGeometry(300, 100, 100);
      this.mesh = new THREE.Mesh(this.sphere);
      this.mesh.scale.x = -1;
      this.scene.add(this.mesh);
      this.autoRotate = false;
      this.running = false;
      _oldWidth = this.width;
      _oldHeight = this.height;
      setInterval((function(_this) {
        return function() {
          if (_oldWidth !== _this.width || _oldHeight !== _this.height) {
            _oldWidth = _this.width;
            _oldHeight = _this.height;

            return _this.renderer.setSize(_this.width, _this.height);
          }
        };
      })(this), 100);
    }

    ThetaViewer.prototype.distance = function(distance) {
      this.controls.distance (distance);
    };
    ThetaViewer.prototype.setEnable = function(enable) {
      this.controls.enabled = enable;
    };
    ThetaViewer.prototype.load = function(callback) {
      if (!callback) {
        callback = function() {};
      }
      return this.loadMaterials((function(_this) {

        return function() {
          if (_this.running) {
            return;
          }
          _this.running = true;
          _this.displayNextMaterial();
          callback ();

          setInterval(function() {
            return _this.displayNextMaterial();
          }, _this.interval);

          if (_this.autoRotate) {
            return setInterval(function() {
              _this.controls.rotateLeft(0.003);
              return _this.controls.update();
            }, 50);
          }

        };
      })(this));
    };

    ThetaViewer.prototype.loadMaterials = function(callback) {
      var mapping;
      mapping = new THREE.UVMapping;
      return async.map(this.images, function(img, done) {
        var texture;
        THREE.ImageUtils.crossOrigin = 'pic.360.ioa.tw';
        return texture = THREE.ImageUtils.loadTexture(img, mapping, function() {
          var material;
          material = new THREE.MeshBasicMaterial({
            map: texture
          });
          return done(null, material);
        });
      }, (function(_this) {
        return function(err, results) {
          _this.materials = results;
          return callback();
        };
      })(this));
    };

    ThetaViewer.prototype.displayNextMaterial = function() {
      this.materialOffset += 1;
      if (!(this.materialOffset < this.materials.length)) {
        this.materialOffset = 0;
      }
      this.mesh.material = this.materials[this.materialOffset];
      return this.renderer.render(this.scene, this.camera);
    };

    return ThetaViewer;

  })();

  if ((typeof module !== "undefined" && module !== null ? module.exports : void 0) != null) {
    module.exports = ThetaViewer;
  } else {
    window.ThetaViewer = ThetaViewer;
  }

}).call(this);
