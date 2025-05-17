document.addEventListener('DOMContentLoaded', () => {
  const options = window.DDG_WAWE_OPTIONS || {};
  const waveCount = parseInt(options.wave_count) || 3;

  const defaultColors = [
    "rgba(255,255,255,0.3)",
    "rgba(255,255,255,0.2)",
    "rgba(255,255,255,0.1)",
    "rgba(255,255,255,0.2)",
    "rgba(255,255,255,0.3)"
  ];

  const waves = Array.from({ length: waveCount }, (_, i) => ({
    timeModifier: 1,
    lineWidth: 2 - (i * 0.3),
    amplitude: 100 - (i * 20),
    wavelength: 100 + (i * 50),
    segmentLength: 10,
    strokeStyle: options[`wave_color_${i+1}`] || defaultColors[i]
  }));

  class SineWaveGenerator {
    constructor({ el, speed = 8, waves = [] }) {
      if (!el) return;
      this.el = el;
      this.ctx = el.getContext('2d');
      this.speed = speed;
      this.waves = waves;
      this.time = 0;
      this._resizeCanvas();
      window.addEventListener('resize', () => this._resizeCanvas());
      this._loop();
    }

    _resizeCanvas() {
      this.dpr = window.devicePixelRatio || 1;
      this.width = this.el.width = window.innerWidth * this.dpr;
      this.height = this.el.height = window.innerHeight * this.dpr;
      this.el.style.width = window.innerWidth + 'px';
      this.el.style.height = window.innerHeight + 'px';
      this.waveWidth = this.width * 0.95;
      this.waveLeft = this.width * 0.025;
    }

    _clear() {
      this.ctx.clearRect(0, 0, this.width, this.height);
    }

    _drawSine(time, wave) {
      const { ctx, waveLeft, waveWidth, height, speed } = this;
      const yAxis = height / 2;
      let x, y;
      ctx.lineWidth = wave.lineWidth;
      ctx.strokeStyle = wave.strokeStyle;
      ctx.beginPath();
      ctx.moveTo(0, yAxis);
      ctx.lineTo(waveLeft, yAxis);

      for (let i = 0; i < waveWidth; i += wave.segmentLength) {
        x = (time * speed) + (-yAxis + i) / wave.wavelength;
        y = Math.sin(x);
        const amp = wave.amplitude * (Math.sin(i / waveWidth * Math.PI * 2 - Math.PI / 2) + 1) * 0.5;
        ctx.lineTo(i + waveLeft, amp * y + yAxis);
      }

      ctx.lineTo(this.width, yAxis);
      ctx.stroke();
    }

    _update() {
      this.time -= 0.007;
      this.waves.forEach(wave => this._drawSine(this.time, wave));
    }

    _loop() {
      this._clear();
      this._update();
      requestAnimationFrame(this._loop.bind(this));
    }
  }

  const canvas = document.getElementById('waves');
  if (canvas) {
    new SineWaveGenerator({ el: canvas, waves });
  }
});
