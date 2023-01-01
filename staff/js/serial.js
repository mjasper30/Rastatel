(function () {
  var e = window.AmCharts;
  e.AmRectangularChart = e.Class({
    inherits: e.AmCoordinateChart,
    construct: function (a) {
      e.AmRectangularChart.base.construct.call(this, a);
      this.theme = a;
      this.createEvents("zoomed", "changed");
      this.marginRight =
        this.marginBottom =
        this.marginTop =
        this.marginLeft =
          20;
      this.depth3D = this.angle = 0;
      this.plotAreaFillColors = "#FFFFFF";
      this.plotAreaFillAlphas = 0;
      this.plotAreaBorderColor = "#000000";
      this.plotAreaBorderAlpha = 0;
      this.maxZoomFactor = 20;
      this.zoomOutButtonImageSize = 19;
      this.zoomOutButtonImage = "lens";
      this.zoomOutText = "Show all";
      this.zoomOutButtonColor = "#e5e5e5";
      this.zoomOutButtonAlpha = 0;
      this.zoomOutButtonRollOverAlpha = 1;
      this.zoomOutButtonPadding = 8;
      this.trendLines = [];
      this.autoMargins = !0;
      this.marginsUpdated = !1;
      this.autoMarginOffset = 10;
      e.applyTheme(this, a, "AmRectangularChart");
    },
    initChart: function () {
      e.AmRectangularChart.base.initChart.call(this);
      this.updateDxy();
      !this.marginsUpdated &&
        this.autoMargins &&
        (this.resetMargins(), (this.drawGraphs = !1));
      this.processScrollbars();
      this.updateMargins();
      this.updatePlotArea();
      this.updateScrollbars();
      this.updateTrendLines();
      this.updateChartCursor();
      this.updateValueAxes();
      this.scrollbarOnly || this.updateGraphs();
    },
    drawChart: function () {
      e.AmRectangularChart.base.drawChart.call(this);
      this.drawPlotArea();
      if (e.ifArray(this.chartData)) {
        var a = this.chartCursor;
        a && a.draw();
      }
    },
    resetMargins: function () {
      var a = {},
        b;
      if ("xy" == this.type) {
        var c = this.xAxes,
          d = this.yAxes;
        for (b = 0; b < c.length; b++) {
          var g = c[b];
          g.ignoreAxisWidth ||
            (g.setOrientation(!0), g.fixAxisPosition(), (a[g.position] = !0));
        }
        for (b = 0; b < d.length; b++)
          (c = d[b]),
            c.ignoreAxisWidth ||
              (c.setOrientation(!1), c.fixAxisPosition(), (a[c.position] = !0));
      } else {
        d = this.valueAxes;
        for (b = 0; b < d.length; b++)
          (c = d[b]),
            c.ignoreAxisWidth ||
              (c.setOrientation(this.rotate),
              c.fixAxisPosition(),
              (a[c.position] = !0));
        (b = this.categoryAxis) &&
          !b.ignoreAxisWidth &&
          (b.setOrientation(!this.rotate),
          b.fixAxisPosition(),
          b.fixAxisPosition(),
          (a[b.position] = !0));
      }
      a.left && (this.marginLeft = 0);
      a.right && (this.marginRight = 0);
      a.top && (this.marginTop = 0);
      a.bottom && (this.marginBottom = 0);
      this.fixMargins = a;
    },
    measureMargins: function () {
      var a = this.valueAxes,
        b,
        c = this.autoMarginOffset,
        d = this.fixMargins,
        g = this.realWidth,
        h = this.realHeight,
        f = c,
        e = c,
        l = g;
      b = h;
      var m;
      for (m = 0; m < a.length; m++)
        a[m].handleSynchronization(),
          (b = this.getAxisBounds(a[m], f, l, e, b)),
          (f = Math.round(b.l)),
          (l = Math.round(b.r)),
          (e = Math.round(b.t)),
          (b = Math.round(b.b));
      if ((a = this.categoryAxis))
        (b = this.getAxisBounds(a, f, l, e, b)),
          (f = Math.round(b.l)),
          (l = Math.round(b.r)),
          (e = Math.round(b.t)),
          (b = Math.round(b.b));
      d.left && f < c && (this.marginLeft = Math.round(-f + c));
      d.right && l >= g - c && (this.marginRight = Math.round(l - g + c));
      d.top &&
        e < c + this.titleHeight &&
        (this.marginTop = Math.round(
          this.marginTop - e + c + this.titleHeight
        ));
      d.bottom &&
        b > h - c &&
        (this.marginBottom = Math.round(this.marginBottom + b - h + c));
      this.initChart();
    },
    getAxisBounds: function (a, b, c, d, g) {
      if (!a.ignoreAxisWidth) {
        var e = a.labelsSet,
          f = a.tickLength;
        a.inside && (f = 0);
        if (e)
          switch (((e = a.getBBox()), a.position)) {
            case "top":
              a = e.y;
              d > a && (d = a);
              break;
            case "bottom":
              a = e.y + e.height;
              g < a && (g = a);
              break;
            case "right":
              a = e.x + e.width + f + 3;
              c < a && (c = a);
              break;
            case "left":
              (a = e.x - f), b > a && (b = a);
          }
      }
      return { l: b, t: d, r: c, b: g };
    },
    drawZoomOutButton: function () {
      var a = this;
      if (!a.zbSet) {
        var b = a.container.set();
        a.zoomButtonSet.push(b);
        var c = a.color,
          d = a.fontSize,
          g = a.zoomOutButtonImageSize,
          h = a.zoomOutButtonImage.replace(/\.[a-z]*$/i, ""),
          f = e.lang.zoomOutText || a.zoomOutText,
          k = a.zoomOutButtonColor,
          l = a.zoomOutButtonAlpha,
          m = a.zoomOutButtonFontSize,
          q = a.zoomOutButtonPadding;
        isNaN(m) || (d = m);
        (m = a.zoomOutButtonFontColor) && (c = m);
        var m = a.zoomOutButton,
          n;
        m &&
          (m.fontSize && (d = m.fontSize),
          m.color && (c = m.color),
          m.backgroundColor && (k = m.backgroundColor),
          isNaN(m.backgroundAlpha) ||
            (a.zoomOutButtonRollOverAlpha = m.backgroundAlpha));
        var p = (m = 0);
        void 0 !== a.pathToImages &&
          h &&
          ((n = a.container.image(
            a.pathToImages + h + a.extension,
            0,
            0,
            g,
            g
          )),
          e.setCN(a, n, "zoom-out-image"),
          b.push(n),
          (n = n.getBBox()),
          (m = n.width + 5));
        void 0 !== f &&
          ((c = e.text(a.container, f, c, a.fontFamily, d, "start")),
          e.setCN(a, c, "zoom-out-label"),
          (d = c.getBBox()),
          (p = n ? n.height / 2 - 3 : d.height / 2),
          c.translate(m, p),
          b.push(c));
        n = b.getBBox();
        c = 1;
        e.isModern || (c = 0);
        k = e.rect(
          a.container,
          n.width + 2 * q + 5,
          n.height + 2 * q - 2,
          k,
          1,
          1,
          k,
          c
        );
        k.setAttr("opacity", l);
        k.translate(-q, -q);
        e.setCN(a, k, "zoom-out-bg");
        b.push(k);
        k.toBack();
        a.zbBG = k;
        n = k.getBBox();
        b.translate(
          a.marginLeftReal + a.plotAreaWidth - n.width + q,
          a.marginTopReal + q
        );
        b.hide();
        b.mouseover(function () {
          a.rollOverZB();
        })
          .mouseout(function () {
            a.rollOutZB();
          })
          .click(function () {
            a.clickZB();
          })
          .touchstart(function () {
            a.rollOverZB();
          })
          .touchend(function () {
            a.rollOutZB();
            a.clickZB();
          });
        for (l = 0; l < b.length; l++) b[l].attr({ cursor: "pointer" });
        a.zbSet = b;
      }
    },
    rollOverZB: function () {
      this.rolledOverZB = !0;
      this.zbBG.setAttr("opacity", this.zoomOutButtonRollOverAlpha);
    },
    rollOutZB: function () {
      this.rolledOverZB = !1;
      this.zbBG.setAttr("opacity", this.zoomOutButtonAlpha);
    },
    clickZB: function () {
      this.rolledOverZB = !1;
      this.zoomOut();
    },
    zoomOut: function () {
      this.zoomOutValueAxes();
    },
    drawPlotArea: function () {
      var a = this.dx,
        b = this.dy,
        c = this.marginLeftReal,
        d = this.marginTopReal,
        g = this.plotAreaWidth - 1,
        h = this.plotAreaHeight - 1,
        f = this.plotAreaFillColors,
        k = this.plotAreaFillAlphas,
        l = this.plotAreaBorderColor,
        m = this.plotAreaBorderAlpha;
      "object" == typeof k && (k = k[0]);
      f = e.polygon(
        this.container,
        [0, g, g, 0, 0],
        [0, 0, h, h, 0],
        f,
        k,
        1,
        l,
        m,
        this.plotAreaGradientAngle
      );
      e.setCN(this, f, "plot-area");
      f.translate(c + a, d + b);
      this.set.push(f);
      0 !== a &&
        0 !== b &&
        ((f = this.plotAreaFillColors),
        "object" == typeof f && (f = f[0]),
        (f = e.adjustLuminosity(f, -0.15)),
        (g = e.polygon(
          this.container,
          [0, a, g + a, g, 0],
          [0, b, b, 0, 0],
          f,
          k,
          1,
          l,
          m
        )),
        e.setCN(this, g, "plot-area-bottom"),
        g.translate(c, d + h),
        this.set.push(g),
        (a = e.polygon(
          this.container,
          [0, 0, a, a, 0],
          [0, h, h + b, b, 0],
          f,
          k,
          1,
          l,
          m
        )),
        e.setCN(this, a, "plot-area-left"),
        a.translate(c, d),
        this.set.push(a));
      (c = this.bbset) && this.scrollbarOnly && c.remove();
    },
    updatePlotArea: function () {
      var a = this.updateWidth(),
        b = this.updateHeight(),
        c = this.container;
      this.realWidth = a;
      this.realWidth = b;
      c && this.container.setSize(a, b);
      var c = this.marginLeftReal,
        d = this.marginTopReal,
        a = a - c - this.marginRightReal - this.dx,
        b = b - d - this.marginBottomReal;
      1 > a && (a = 1);
      1 > b && (b = 1);
      this.plotAreaWidth = Math.round(a);
      this.plotAreaHeight = Math.round(b);
      this.plotBalloonsSet.translate(c, d);
    },
    updateDxy: function () {
      this.dx = Math.round(
        this.depth3D * Math.cos((this.angle * Math.PI) / 180)
      );
      this.dy = Math.round(
        -this.depth3D * Math.sin((this.angle * Math.PI) / 180)
      );
      this.d3x = Math.round(
        this.columnSpacing3D * Math.cos((this.angle * Math.PI) / 180)
      );
      this.d3y = Math.round(
        -this.columnSpacing3D * Math.sin((this.angle * Math.PI) / 180)
      );
    },
    updateMargins: function () {
      var a = this.getTitleHeight();
      this.titleHeight = a;
      this.marginTopReal = this.marginTop - this.dy;
      this.fixMargins && !this.fixMargins.top && (this.marginTopReal += a);
      this.marginBottomReal = this.marginBottom;
      this.marginLeftReal = this.marginLeft;
      this.marginRightReal = this.marginRight;
    },
    updateValueAxes: function () {
      var a = this.valueAxes,
        b;
      for (b = 0; b < a.length; b++) {
        var c = a[b];
        this.setAxisRenderers(c);
        this.updateObjectSize(c);
      }
    },
    setAxisRenderers: function (a) {
      a.axisRenderer = e.RecAxis;
      a.guideFillRenderer = e.RecFill;
      a.axisItemRenderer = e.RecItem;
      a.marginsChanged = !0;
    },
    updateGraphs: function () {
      var a = this.graphs,
        b;
      for (b = 0; b < a.length; b++) {
        var c = a[b];
        c.index = b;
        c.rotate = this.rotate;
        this.updateObjectSize(c);
      }
    },
    updateObjectSize: function (a) {
      a.width = this.plotAreaWidth - 1;
      a.height = this.plotAreaHeight - 1;
      a.x = this.marginLeftReal;
      a.y = this.marginTopReal;
      a.dx = this.dx;
      a.dy = this.dy;
    },
    updateChartCursor: function () {
      var a = this.chartCursor;
      a &&
        ((a = e.processObject(a, e.ChartCursor, this.theme)),
        this.updateObjectSize(a),
        this.addChartCursor(a),
        (a.chart = this));
    },
    processScrollbars: function () {
      var a = this.chartScrollbar;
      a &&
        ((a = e.processObject(a, e.ChartScrollbar, this.theme)),
        this.addChartScrollbar(a));
    },
    updateScrollbars: function () {},
    removeChartCursor: function () {
      e.callMethod("destroy", [this.chartCursor]);
      this.chartCursor = null;
    },
    zoomTrendLines: function () {
      var a = this.trendLines,
        b;
      for (b = 0; b < a.length; b++) {
        var c = a[b];
        c.valueAxis.recalculateToPercents
          ? c.set && c.set.hide()
          : ((c.x = this.marginLeftReal), (c.y = this.marginTopReal), c.draw());
      }
    },
    handleCursorValueZoom: function () {},
    addTrendLine: function (a) {
      this.trendLines.push(a);
    },
    zoomOutValueAxes: function () {
      for (var a = this.valueAxes, b = 0; b < a.length; b++) a[b].zoomOut();
    },
    removeTrendLine: function (a) {
      var b = this.trendLines,
        c;
      for (c = b.length - 1; 0 <= c; c--) b[c] == a && b.splice(c, 1);
    },
    adjustMargins: function (a, b) {
      var c = a.position,
        d = a.scrollbarHeight + a.offset;
      a.enabled &&
        ("top" == c
          ? b
            ? (this.marginLeftReal += d)
            : (this.marginTopReal += d)
          : b
          ? (this.marginRightReal += d)
          : (this.marginBottomReal += d));
    },
    getScrollbarPosition: function (a, b, c) {
      var d = "bottom",
        g = "top";
      a.oppositeAxis || ((g = d), (d = "top"));
      a.position = b
        ? "bottom" == c || "left" == c
          ? d
          : g
        : "top" == c || "right" == c
        ? d
        : g;
    },
    updateChartScrollbar: function (a, b) {
      if (a) {
        a.rotate = b;
        var c = this.marginTopReal,
          d = this.marginLeftReal,
          g = a.scrollbarHeight,
          e = this.dx,
          f = this.dy,
          k = a.offset;
        "top" == a.position
          ? b
            ? ((a.y = c), (a.x = d - g - k))
            : ((a.y = c - g + f - k), (a.x = d + e))
          : b
          ? ((a.y = c + f), (a.x = d + this.plotAreaWidth + e + k))
          : ((a.y = c + this.plotAreaHeight + k), (a.x = this.marginLeftReal));
      }
    },
    showZB: function (a) {
      var b = this.zbSet;
      a && ((b = this.zoomOutText), "" !== b && b && this.drawZoomOutButton());
      if ((b = this.zbSet))
        this.zoomButtonSet.push(b), a ? b.show() : b.hide(), this.rollOutZB();
    },
    handleReleaseOutside: function (a) {
      e.AmRectangularChart.base.handleReleaseOutside.call(this, a);
      (a = this.chartCursor) &&
        a.handleReleaseOutside &&
        a.handleReleaseOutside();
    },
    handleMouseDown: function (a) {
      e.AmRectangularChart.base.handleMouseDown.call(this, a);
      var b = this.chartCursor;
      b && b.handleMouseDown && !this.rolledOverZB && b.handleMouseDown(a);
    },
    update: function () {
      e.AmRectangularChart.base.update.call(this);
      this.chartCursor && this.chartCursor.update && this.chartCursor.update();
    },
    handleScrollbarValueZoom: function (a) {
      this.relativeZoomValueAxes(
        a.target.valueAxes,
        a.relativeStart,
        a.relativeEnd
      );
      this.zoomAxesAndGraphs();
    },
    zoomValueScrollbar: function (a) {
      if (a && a.enabled) {
        var b = a.valueAxes[0],
          c = b.relativeStart,
          d = b.relativeEnd;
        b.reversed && ((d = 1 - c), (c = 1 - b.relativeEnd));
        a.percentZoom(c, d);
      }
    },
    zoomAxesAndGraphs: function () {
      if (!this.scrollbarOnly) {
        var a = this.valueAxes,
          b;
        for (b = 0; b < a.length; b++) a[b].zoom(this.start, this.end);
        a = this.graphs;
        for (b = 0; b < a.length; b++) a[b].zoom(this.start, this.end);
        (b = this.chartCursor) && b.clearSelection();
        this.zoomTrendLines();
      }
    },
    handleValueAxisZoomReal: function (a, b) {
      var c = a.relativeStart,
        d = a.relativeEnd;
      if (c > d)
        var g = c,
          c = d,
          d = g;
      this.relativeZoomValueAxes(b, c, d);
      this.updateAfterValueZoom();
    },
    updateAfterValueZoom: function () {
      this.zoomAxesAndGraphs();
      this.zoomScrollbar();
    },
    relativeZoomValueAxes: function (a, b, c) {
      b = e.fitToBounds(b, 0, 1);
      c = e.fitToBounds(c, 0, 1);
      if (b > c) {
        var d = b;
        b = c;
        c = d;
      }
      var d = 1 / this.maxZoomFactor,
        g = e.getDecimals(d) + 4;
      c - b < d && ((c = b + (c - b) / 2), (b = c - d / 2), (c += d / 2));
      b = e.roundTo(b, g);
      c = e.roundTo(c, g);
      d = !1;
      if (a) {
        for (g = 0; g < a.length; g++) {
          var h = a[g].zoomToRelativeValues(b, c, !0);
          h && (d = h);
        }
        this.showZB();
      }
      return d;
    },
    addChartCursor: function (a) {
      e.callMethod("destroy", [this.chartCursor]);
      a &&
        (this.listenTo(a, "moved", this.handleCursorMove),
        this.listenTo(a, "zoomed", this.handleCursorZoom),
        this.listenTo(a, "zoomStarted", this.handleCursorZoomStarted),
        this.listenTo(a, "panning", this.handleCursorPanning),
        this.listenTo(a, "onHideCursor", this.handleCursorHide));
      this.chartCursor = a;
    },
    handleCursorChange: function () {},
    handleCursorMove: function (a) {
      var b,
        c = this.valueAxes;
      for (b = 0; b < c.length; b++) a.panning || c[b].showBalloon(a.x, a.y);
    },
    handleCursorZoom: function (a) {
      if (this.skipZoomed) this.skipZoomed = !1;
      else {
        var b = this.startX0,
          c = this.endX0,
          d = this.endY0,
          g = this.startY0,
          e = a.startX,
          f = a.endX,
          k = a.startY,
          l = a.endY;
        this.startX0 = this.endX0 = this.startY0 = this.endY0 = NaN;
        this.handleCursorZoomReal(
          b + e * (c - b),
          b + f * (c - b),
          g + k * (d - g),
          g + l * (d - g),
          a
        );
      }
    },
    handleCursorHide: function () {
      var a,
        b = this.valueAxes;
      for (a = 0; a < b.length; a++) b[a].hideBalloon();
      b = this.graphs;
      for (a = 0; a < b.length; a++) b[a].hideBalloonReal();
    },
  });
})();
(function () {
  var e = window.AmCharts;
  e.AmSerialChart = e.Class({
    inherits: e.AmRectangularChart,
    construct: function (a) {
      this.type = "serial";
      e.AmSerialChart.base.construct.call(this, a);
      this.cname = "AmSerialChart";
      this.theme = a;
      this.columnSpacing = 5;
      this.columnSpacing3D = 0;
      this.columnWidth = 0.8;
      var b = new e.CategoryAxis(a);
      b.chart = this;
      this.categoryAxis = b;
      this.zoomOutOnDataUpdate = !0;
      this.mouseWheelZoomEnabled =
        this.mouseWheelScrollEnabled =
        this.rotate =
        this.skipZoom =
          !1;
      this.minSelectedTime = 0;
      e.applyTheme(this, a, this.cname);
    },
    initChart: function () {
      e.AmSerialChart.base.initChart.call(this);
      this.updateCategoryAxis(this.categoryAxis, this.rotate, "categoryAxis");
      if (this.dataChanged) this.parseData();
      else this.onDataUpdated();
      this.drawGraphs = !0;
    },
    onDataUpdated: function () {
      var a = this.countColumns(),
        b = this.chartData,
        c = this.graphs,
        d;
      for (d = 0; d < c.length; d++) {
        var g = c[d];
        g.data = b;
        g.columnCount = a;
      }
      0 < b.length &&
        ((this.firstTime = this.getStartTime(b[0].time)),
        (this.lastTime = this.getEndTime(b[b.length - 1].time)));
      this.drawChart();
      this.autoMargins && !this.marginsUpdated
        ? ((this.marginsUpdated = !0), this.measureMargins())
        : this.dispDUpd();
    },
    handleWheelReal: function (a, b) {
      if (!this.wheelBusy) {
        var c = this.categoryAxis,
          d = c.parseDates,
          g = c.minDuration(),
          e = (c = 1);
        this.mouseWheelZoomEnabled ? b || (c = -1) : b && (c = -1);
        var f = this.chartData.length,
          k = this.lastTime,
          l = this.firstTime;
        0 > a
          ? d
            ? ((f = this.endTime - this.startTime),
              (d = this.startTime + c * g),
              (g = this.endTime + e * g),
              0 < e && 0 < c && g >= k && ((g = k), (d = k - f)),
              this.zoomToDates(new Date(d), new Date(g)))
            : (0 < e && 0 < c && this.end >= f - 1 && (c = e = 0),
              (d = this.start + c),
              (g = this.end + e),
              this.zoomToIndexes(d, g))
          : d
          ? ((f = this.endTime - this.startTime),
            (d = this.startTime - c * g),
            (g = this.endTime - e * g),
            0 < e && 0 < c && d <= l && ((d = l), (g = l + f)),
            this.zoomToDates(new Date(d), new Date(g)))
          : (0 < e && 0 < c && 1 > this.start && (c = e = 0),
            (d = this.start - c),
            (g = this.end - e),
            this.zoomToIndexes(d, g));
      }
    },
    validateData: function (a) {
      this.marginsUpdated = !1;
      this.zoomOutOnDataUpdate &&
        !a &&
        (this.endTime = this.end = this.startTime = this.start = NaN);
      e.AmSerialChart.base.validateData.call(this);
    },
    drawChart: function () {
      if (0 < this.realWidth && 0 < this.realHeight) {
        e.AmSerialChart.base.drawChart.call(this);
        var a = this.chartData;
        if (e.ifArray(a)) {
          var b = this.chartScrollbar;
          !b || (!this.marginsUpdated && this.autoMargins) || b.draw();
          (b = this.valueScrollbar) && b.draw();
          var a = a.length - 1,
            c,
            b = this.categoryAxis;
          if (b.parseDates && !b.equalSpacing) {
            if (
              ((b = this.startTime), (c = this.endTime), isNaN(b) || isNaN(c))
            )
              (b = this.firstTime), (c = this.lastTime);
          } else if (((b = this.start), (c = this.end), isNaN(b) || isNaN(c)))
            (b = 0), (c = a);
          this.endTime = this.startTime = this.end = this.start = void 0;
          this.zoom(b, c);
        }
      } else this.cleanChart();
    },
    cleanChart: function () {
      e.callMethod("destroy", [
        this.valueAxes,
        this.graphs,
        this.categoryAxis,
        this.chartScrollbar,
        this.chartCursor,
        this.valueScrollbar,
      ]);
    },
    updateCategoryAxis: function (a, b, c) {
      a.chart = this;
      a.id = c;
      a.rotate = b;
      a.setOrientation(!this.rotate);
      a.init();
      this.setAxisRenderers(a);
      this.updateObjectSize(a);
    },
    updateValueAxes: function () {
      e.AmSerialChart.base.updateValueAxes.call(this);
      var a = this.valueAxes,
        b;
      for (b = 0; b < a.length; b++) {
        var c = a[b],
          d = this.rotate;
        c.rotate = d;
        c.setOrientation(d);
        d = this.categoryAxis;
        if (!d.startOnAxis || d.parseDates) c.expandMinMax = !0;
      }
    },
    getStartTime: function (a) {
      var b = this.categoryAxis;
      return e
        .resetDateToMin(new Date(a), b.minPeriod, 1, b.firstDayOfWeek)
        .getTime();
    },
    getEndTime: function (a) {
      var b = e.extractPeriod(this.categoryAxis.minPeriod);
      return e.changeDate(new Date(a), b.period, b.count, !0).getTime() - 1;
    },
    updateMargins: function () {
      e.AmSerialChart.base.updateMargins.call(this);
      var a = this.chartScrollbar;
      a &&
        (this.getScrollbarPosition(a, this.rotate, this.categoryAxis.position),
        this.adjustMargins(a, this.rotate));
      if ((a = this.valueScrollbar))
        this.getScrollbarPosition(a, !this.rotate, this.valueAxes[0].position),
          this.adjustMargins(a, !this.rotate);
    },
    updateScrollbars: function () {
      e.AmSerialChart.base.updateScrollbars.call(this);
      this.updateChartScrollbar(this.chartScrollbar, this.rotate);
      this.updateChartScrollbar(this.valueScrollbar, !this.rotate);
    },
    zoom: function (a, b) {
      var c = this.categoryAxis;
      c.parseDates && !c.equalSpacing
        ? this.timeZoom(a, b)
        : this.indexZoom(a, b);
      isNaN(a) && this.zoomOutValueAxes();
      this.updateLegendValues();
    },
    timeZoom: function (a, b) {
      var c = this.maxSelectedTime;
      isNaN(c) ||
        (b != this.endTime && b - a > c && (a = b - c),
        a != this.startTime && b - a > c && (b = a + c));
      var d = this.minSelectedTime;
      if (0 < d && b - a < d) {
        var g = Math.round(a + (b - a) / 2),
          d = Math.round(d / 2);
        a = g - d;
        b = g + d;
      }
      d = this.chartData;
      g = this.categoryAxis;
      if (e.ifArray(d) && (a != this.startTime || b != this.endTime)) {
        var h = g.minDuration(),
          f = this.firstTime,
          k = this.lastTime;
        a || ((a = f), isNaN(c) || (a = k - c));
        b || (b = k);
        a > k && (a = k);
        b < f && (b = f);
        a < f && (a = f);
        b > k && (b = k);
        b < a && (b = a + h);
        b - a < h / 5 && (b < k ? (b = a + h / 5) : (a = b - h / 5));
        this.startTime = a;
        this.endTime = b;
        c = d.length - 1;
        h = this.getClosestIndex(d, "time", a, !0, 0, c);
        d = this.getClosestIndex(d, "time", b, !1, h, c);
        g.timeZoom(a, b);
        g.zoom(h, d);
        this.start = e.fitToBounds(h, 0, c);
        this.end = e.fitToBounds(d, 0, c);
        this.zoomAxesAndGraphs();
        this.zoomScrollbar();
        this.fixCursor();
        this.showZB();
        this.updateColumnsDepth();
        this.dispatchTimeZoomEvent();
      }
    },
    showZB: function () {
      var a,
        b = this.categoryAxis;
      b &&
        b.parseDates &&
        !b.equalSpacing &&
        (this.startTime > this.firstTime && (a = !0),
        this.endTime < this.lastTime && (a = !0));
      0 < this.start && (a = !0);
      this.end < this.chartData.length - 1 && (a = !0);
      if ((b = this.valueAxes))
        (b = b[0]),
          0 !== b.relativeStart && (a = !0),
          1 != b.relativeEnd && (a = !0);
      e.AmSerialChart.base.showZB.call(this, a);
    },
    updateAfterValueZoom: function () {
      e.AmSerialChart.base.updateAfterValueZoom.call(this);
      this.updateColumnsDepth();
    },
    indexZoom: function (a, b) {
      var c = this.maxSelectedSeries;
      isNaN(c) ||
        (b != this.end && b - a > c && (a = b - c),
        a != this.start && b - a > c && (b = a + c));
      if (a != this.start || b != this.end) {
        var d = this.chartData.length - 1;
        isNaN(a) && ((a = 0), isNaN(c) || (a = d - c));
        isNaN(b) && (b = d);
        b < a && (b = a);
        b > d && (b = d);
        a > d && (a = d - 1);
        0 > a && (a = 0);
        this.start = a;
        this.end = b;
        this.categoryAxis.zoom(a, b);
        this.zoomAxesAndGraphs();
        this.zoomScrollbar();
        this.fixCursor();
        0 !== a || b != this.chartData.length - 1
          ? this.showZB(!0)
          : this.showZB(!1);
        this.updateColumnsDepth();
        this.dispatchIndexZoomEvent();
      }
    },
    updateGraphs: function () {
      e.AmSerialChart.base.updateGraphs.call(this);
      var a = this.graphs,
        b;
      for (b = 0; b < a.length; b++) {
        var c = a[b];
        c.columnWidthReal = this.columnWidth;
        c.categoryAxis = this.categoryAxis;
        e.isString(c.fillToGraph) &&
          (c.fillToGraph = this.graphsById[c.fillToGraph]);
      }
    },
    zoomAxesAndGraphs: function () {
      e.AmSerialChart.base.zoomAxesAndGraphs.call(this);
      this.updateColumnsDepth();
    },
    updateColumnsDepth: function () {
      if (0 !== this.depth3D || 0 !== this.angle) {
        var a,
          b = this.graphs,
          c;
        this.columnsArray = [];
        for (a = 0; a < b.length; a++) {
          c = b[a];
          var d = c.columnsArray;
          if (d) {
            var g;
            for (g = 0; g < d.length; g++) this.columnsArray.push(d[g]);
          }
        }
        this.columnsArray.sort(this.compareDepth);
        if (0 < this.columnsArray.length) {
          b = this.columnsSet;
          d = this.container.set();
          this.columnSet.push(d);
          for (a = 0; a < this.columnsArray.length; a++)
            d.push(this.columnsArray[a].column.set);
          c && d.translate(c.x, c.y);
          this.columnsSet = d;
          e.remove(b);
        }
      }
    },
    compareDepth: function (a, b) {
      return a.depth > b.depth ? 1 : -1;
    },
    zoomScrollbar: function () {
      var a = this.chartScrollbar,
        b = this.categoryAxis;
      if (a) {
        if (!this.zoomedByScrollbar) {
          var c = a.dragger;
          c && c.stop();
        }
        this.zoomedByScrollbar = !1;
        b.parseDates && !b.equalSpacing
          ? a.timeZoom(this.startTime, this.endTime)
          : a.zoom(this.start, this.end);
      }
      this.zoomValueScrollbar(this.valueScrollbar);
    },
    updateTrendLines: function () {
      var a = this.trendLines,
        b;
      for (b = 0; b < a.length; b++) {
        var c = a[b],
          c = e.processObject(c, e.TrendLine, this.theme);
        a[b] = c;
        c.chart = this;
        c.id || (c.id = "trendLineAuto" + b + "_" + new Date().getTime());
        e.isString(c.valueAxis) &&
          (c.valueAxis = this.getValueAxisById(c.valueAxis));
        c.valueAxis || (c.valueAxis = this.valueAxes[0]);
        c.categoryAxis = this.categoryAxis;
      }
    },
    countColumns: function () {
      var a = 0,
        b = this.valueAxes.length,
        c = this.graphs.length,
        d,
        g,
        e = !1,
        f,
        k;
      for (k = 0; k < b; k++) {
        g = this.valueAxes[k];
        var l = g.stackType;
        if ("100%" == l || "regular" == l)
          for (e = !1, f = 0; f < c; f++)
            (d = this.graphs[f]),
              (d.tcc = 1),
              d.valueAxis == g &&
                "column" == d.type &&
                (!e && d.stackable && (a++, (e = !0)),
                ((!d.stackable && d.clustered) || d.newStack) && a++,
                (d.columnIndex = a - 1),
                d.clustered || (d.columnIndex = 0));
        if ("none" == l || "3d" == l) {
          e = !1;
          for (f = 0; f < c; f++)
            (d = this.graphs[f]),
              d.valueAxis == g &&
                "column" == d.type &&
                (d.clustered
                  ? ((d.tcc = 1),
                    d.newStack && (a = 0),
                    d.hidden || ((d.columnIndex = a), a++))
                  : d.hidden || ((e = !0), (d.tcc = 1), (d.columnIndex = 0)));
          e && 0 === a && (a = 1);
        }
        if ("3d" == l) {
          g = 1;
          for (k = 0; k < c; k++)
            (d = this.graphs[k]),
              d.newStack && g++,
              (d.depthCount = g),
              (d.tcc = a);
          a = g;
        }
      }
      return a;
    },
    parseData: function () {
      e.AmSerialChart.base.parseData.call(this);
      this.parseSerialData(this.dataProvider);
    },
    getCategoryIndexByValue: function (a) {
      var b = this.chartData,
        c;
      for (c = 0; c < b.length; c++) if (b[c].category == a) return c;
    },
    handleScrollbarZoom: function (a) {
      this.zoomedByScrollbar = !0;
      this.zoom(a.start, a.end);
    },
    dispatchTimeZoomEvent: function () {
      if (
        this.drawGraphs &&
        (this.prevStartTime != this.startTime ||
          this.prevEndTime != this.endTime)
      ) {
        var a = { type: "zoomed" };
        a.startDate = new Date(this.startTime);
        a.endDate = new Date(this.endTime);
        a.startIndex = this.start;
        a.endIndex = this.end;
        this.startIndex = this.start;
        this.endIndex = this.end;
        this.startDate = a.startDate;
        this.endDate = a.endDate;
        this.prevStartTime = this.startTime;
        this.prevEndTime = this.endTime;
        var b = this.categoryAxis,
          c = e.extractPeriod(b.minPeriod).period,
          b = b.dateFormatsObject[c];
        a.startValue = e.formatDate(a.startDate, b, this);
        a.endValue = e.formatDate(a.endDate, b, this);
        a.chart = this;
        a.target = this;
        this.fire(a);
      }
    },
    dispatchIndexZoomEvent: function () {
      if (
        this.drawGraphs &&
        (this.prevStartIndex != this.start || this.prevEndIndex != this.end)
      ) {
        this.startIndex = this.start;
        this.endIndex = this.end;
        var a = this.chartData;
        if (e.ifArray(a) && !isNaN(this.start) && !isNaN(this.end)) {
          var b = { chart: this, target: this, type: "zoomed" };
          b.startIndex = this.start;
          b.endIndex = this.end;
          b.startValue = a[this.start].category;
          b.endValue = a[this.end].category;
          this.categoryAxis.parseDates &&
            ((this.startTime = a[this.start].time),
            (this.endTime = a[this.end].time),
            (b.startDate = new Date(this.startTime)),
            (b.endDate = new Date(this.endTime)));
          this.prevStartIndex = this.start;
          this.prevEndIndex = this.end;
          this.fire(b);
        }
      }
    },
    updateLegendValues: function () {
      this.legend && this.legend.updateValues();
    },
    getClosestIndex: function (a, b, c, d, e, h) {
      0 > e && (e = 0);
      h > a.length - 1 && (h = a.length - 1);
      var f = e + Math.round((h - e) / 2),
        k = a[f][b];
      return c == k
        ? f
        : 1 >= h - e
        ? d
          ? e
          : Math.abs(a[e][b] - c) < Math.abs(a[h][b] - c)
          ? e
          : h
        : c == k
        ? f
        : c < k
        ? this.getClosestIndex(a, b, c, d, e, f)
        : this.getClosestIndex(a, b, c, d, f, h);
    },
    zoomToIndexes: function (a, b) {
      var c = this.chartData;
      if (c) {
        var d = c.length;
        0 < d &&
          (0 > a && (a = 0),
          b > d - 1 && (b = d - 1),
          (d = this.categoryAxis),
          d.parseDates && !d.equalSpacing
            ? this.zoom(c[a].time, this.getEndTime(c[b].time))
            : this.zoom(a, b));
      }
    },
    zoomToDates: function (a, b) {
      var c = this.chartData;
      if (c)
        if (this.categoryAxis.equalSpacing) {
          var d = this.getClosestIndex(c, "time", a.getTime(), !0, 0, c.length);
          b = e.resetDateToMin(b, this.categoryAxis.minPeriod, 1);
          c = this.getClosestIndex(c, "time", b.getTime(), !1, 0, c.length);
          this.zoom(d, c);
        } else this.zoom(a.getTime(), b.getTime());
    },
    zoomToCategoryValues: function (a, b) {
      this.chartData &&
        this.zoom(
          this.getCategoryIndexByValue(a),
          this.getCategoryIndexByValue(b)
        );
    },
    formatPeriodString: function (a, b) {
      if (b) {
        var c = ["value", "open", "low", "high", "close"],
          d = "value open low high close average sum count".split(" "),
          g = b.valueAxis,
          h = this.chartData,
          f = b.numberFormatter;
        f || (f = this.nf);
        for (var k = 0; k < c.length; k++) {
          for (
            var l = c[k],
              m = 0,
              q = 0,
              n,
              p,
              x,
              u,
              B,
              r = 0,
              t = 0,
              C,
              v,
              w,
              A,
              z,
              G = this.start;
            G <= this.end;
            G++
          ) {
            var y = h[G];
            if (y && (y = y.axes[g.id].graphs[b.id])) {
              if (y.values) {
                var D = y.values[l];
                if (this.rotate) {
                  if (0 > y.x || y.x > y.graph.height) D = NaN;
                } else if (0 > y.x || y.x > y.graph.width) D = NaN;
                if (!isNaN(D)) {
                  isNaN(n) && (n = D);
                  p = D;
                  if (isNaN(x) || x > D) x = D;
                  if (isNaN(u) || u < D) u = D;
                  B = e.getDecimals(m);
                  var F = e.getDecimals(D),
                    m = m + D,
                    m = e.roundTo(m, Math.max(B, F));
                  q++;
                  B = m / q;
                }
              }
              if (y.percents && ((y = y.percents[l]), !isNaN(y))) {
                isNaN(C) && (C = y);
                v = y;
                if (isNaN(w) || w > y) w = y;
                if (isNaN(A) || A < y) A = y;
                z = e.getDecimals(r);
                D = e.getDecimals(y);
                r += y;
                r = e.roundTo(r, Math.max(z, D));
                t++;
                z = r / t;
              }
            }
          }
          r = {
            open: C,
            close: v,
            high: A,
            low: w,
            average: z,
            sum: r,
            count: t,
          };
          a = e.formatValue(
            a,
            {
              open: n,
              close: p,
              high: u,
              low: x,
              average: B,
              sum: m,
              count: q,
            },
            d,
            f,
            l + "\\.",
            this.usePrefixes,
            this.prefixesOfSmallNumbers,
            this.prefixesOfBigNumbers
          );
          a = e.formatValue(a, r, d, this.pf, "percents\\." + l + "\\.");
        }
      }
      return (a = e.cleanFromEmpty(a));
    },
    formatString: function (a, b, c) {
      if (b) {
        var d = b.graph;
        if (void 0 !== a) {
          if (-1 != a.indexOf("[[category]]")) {
            var g = b.serialDataItem.category;
            if (this.categoryAxis.parseDates) {
              var h = this.balloonDateFormat,
                f = this.chartCursor;
              f &&
                f.categoryBalloonDateFormat &&
                (h = f.categoryBalloonDateFormat);
              h = e.formatDate(g, h, this);
              -1 != h.indexOf("fff") && (h = e.formatMilliseconds(h, g));
              g = h;
            }
            a = a.replace(/\[\[category\]\]/g, String(g));
          }
          g = d.numberFormatter;
          g || (g = this.nf);
          h = b.graph.valueAxis;
          (f = h.duration) &&
            !isNaN(b.values.value) &&
            ((f = e.formatDuration(
              b.values.value,
              f,
              "",
              h.durationUnits,
              h.maxInterval,
              g
            )),
            (a = a.replace(RegExp("\\[\\[value\\]\\]", "g"), f)));
          "date" == h.type &&
            ((h = e.formatDate(new Date(b.values.value), d.dateFormat, this)),
            (f = RegExp("\\[\\[value\\]\\]", "g")),
            (a = a.replace(f, h)),
            (h = e.formatDate(new Date(b.values.open), d.dateFormat, this)),
            (f = RegExp("\\[\\[open\\]\\]", "g")),
            (a = a.replace(f, h)));
          d = "value open low high close total".split(" ");
          h = this.pf;
          a = e.formatValue(a, b.percents, d, h, "percents\\.");
          a = e.formatValue(
            a,
            b.values,
            d,
            g,
            "",
            this.usePrefixes,
            this.prefixesOfSmallNumbers,
            this.prefixesOfBigNumbers
          );
          a = e.formatValue(a, b.values, ["percents"], h);
          -1 != a.indexOf("[[") &&
            (a = e.formatDataContextValue(a, b.dataContext));
          -1 != a.indexOf("[[") &&
            b.graph.customData &&
            (a = e.formatDataContextValue(a, b.graph.customData));
          a = e.AmSerialChart.base.formatString.call(this, a, b, c);
        }
        return a;
      }
    },
    updateChartCursor: function () {
      e.AmSerialChart.base.updateChartCursor.call(this);
      var a = this.chartCursor,
        b = this.categoryAxis;
      if (a) {
        var c = a.categoryBalloonAlpha,
          d = a.categoryBalloonColor,
          g = a.color;
        void 0 === d && (d = a.cursorColor);
        var h = a.valueZoomable,
          f = a.zoomable,
          k = a.valueLineEnabled;
        this.rotate
          ? ((a.vLineEnabled = k), (a.hZoomEnabled = h), (a.vZoomEnabled = f))
          : ((a.hLineEnabled = k), (a.vZoomEnabled = h), (a.hZoomEnabled = f));
        if (a.valueLineBalloonEnabled)
          for (k = 0; k < this.valueAxes.length; k++)
            (h = this.valueAxes[k]),
              (f = h.balloon) || (f = {}),
              (f = e.extend(f, this.balloon, !0)),
              (f.fillColor = d),
              (f.balloonColor = d),
              (f.fillAlpha = c),
              (f.borderColor = d),
              (f.color = g),
              (h.balloon = f);
        else
          for (f = 0; f < this.valueAxes.length; f++)
            (h = this.valueAxes[f]), h.balloon && (h.balloon = null);
        b &&
          ((b.balloonTextFunction = a.categoryBalloonFunction),
          (a.categoryLineAxis = b),
          (b.balloonText = a.categoryBalloonText),
          a.categoryBalloonEnabled &&
            ((f = b.balloon) || (f = {}),
            (f = e.extend(f, this.balloon, !0)),
            (f.fillColor = d),
            (f.balloonColor = d),
            (f.fillAlpha = c),
            (f.borderColor = d),
            (f.color = g),
            (b.balloon = f)),
          b.balloon && (b.balloon.enabled = a.categoryBalloonEnabled));
      }
    },
    addChartScrollbar: function (a) {
      e.callMethod("destroy", [this.chartScrollbar]);
      a &&
        ((a.chart = this),
        this.listenTo(a, "zoomed", this.handleScrollbarZoom));
      this.rotate
        ? void 0 === a.width && (a.width = a.scrollbarHeight)
        : void 0 === a.height && (a.height = a.scrollbarHeight);
      a.gridAxis = this.categoryAxis;
      this.chartScrollbar = a;
    },
    addValueScrollbar: function (a) {
      e.callMethod("destroy", [this.valueScrollbar]);
      a &&
        ((a.chart = this),
        this.listenTo(a, "zoomed", this.handleScrollbarValueZoom),
        this.listenTo(a, "zoomStarted", this.handleCursorZoomStarted));
      var b = a.scrollbarHeight;
      this.rotate
        ? void 0 === a.height && (a.height = b)
        : void 0 === a.width && (a.width = b);
      a.gridAxis || (a.gridAxis = this.valueAxes[0]);
      a.valueAxes = this.valueAxes;
      this.valueScrollbar = a;
    },
    removeChartScrollbar: function () {
      e.callMethod("destroy", [this.chartScrollbar]);
      this.chartScrollbar = null;
    },
    removeValueScrollbar: function () {
      e.callMethod("destroy", [this.valueScrollbar]);
      this.valueScrollbar = null;
    },
    handleReleaseOutside: function (a) {
      e.AmSerialChart.base.handleReleaseOutside.call(this, a);
      e.callMethod("handleReleaseOutside", [
        this.chartScrollbar,
        this.valueScrollbar,
      ]);
    },
    update: function () {
      e.AmSerialChart.base.update.call(this);
      this.chartScrollbar &&
        this.chartScrollbar.update &&
        this.chartScrollbar.update();
      this.valueScrollbar &&
        this.valueScrollbar.update &&
        this.valueScrollbar.update();
    },
    processScrollbars: function () {
      e.AmSerialChart.base.processScrollbars.call(this);
      var a = this.valueScrollbar;
      a &&
        ((a = e.processObject(a, e.ChartScrollbar, this.theme)),
        (a.id = "valueScrollbar"),
        this.addValueScrollbar(a));
    },
    handleValueAxisZoom: function (a) {
      this.handleValueAxisZoomReal(a, this.valueAxes);
    },
    zoomOut: function () {
      e.AmSerialChart.base.zoomOut.call(this);
      this.zoom();
    },
    getNextItem: function (a) {
      var b = a.index,
        c = this.chartData,
        d = a.graph;
      if (b + 1 < c.length)
        for (b += 1; b < c.length; b++)
          if ((a = c[b]))
            if (((a = a.axes[d.valueAxis.id].graphs[d.id]), !isNaN(a.y)))
              return a;
    },
    handleCursorZoomReal: function (a, b, c, d, e) {
      var h = e.target,
        f,
        k;
      this.rotate
        ? (isNaN(a) ||
            isNaN(b) ||
            (this.relativeZoomValueAxes(this.valueAxes, a, b) &&
              this.updateAfterValueZoom()),
          h.vZoomEnabled && ((f = e.start), (k = e.end)))
        : (isNaN(c) ||
            isNaN(d) ||
            (this.relativeZoomValueAxes(this.valueAxes, c, d) &&
              this.updateAfterValueZoom()),
          h.hZoomEnabled && ((f = e.start), (k = e.end)));
      isNaN(f) ||
        isNaN(k) ||
        ((a = this.categoryAxis),
        a.parseDates && !a.equalSpacing
          ? this.zoomToDates(new Date(f), new Date(k))
          : this.zoomToIndexes(f, k));
    },
    handleCursorZoomStarted: function () {
      var a = this.valueAxes;
      if (a) {
        var a = a[0],
          b = a.relativeStart,
          c = a.relativeEnd;
        a.reversed && ((b = 1 - a.relativeEnd), (c = 1 - a.relativeStart));
        this.rotate
          ? ((this.startX0 = b), (this.endX0 = c))
          : ((this.startY0 = b), (this.endY0 = c));
      }
      this.categoryAxis &&
        ((this.start0 = this.start),
        (this.end0 = this.end),
        (this.startTime0 = this.startTime),
        (this.endTime0 = this.endTime));
    },
    fixCursor: function () {
      this.chartCursor && this.chartCursor.fixPosition();
      this.prevCursorItem = null;
    },
    handleCursorMove: function (a) {
      e.AmSerialChart.base.handleCursorMove.call(this, a);
      var b = a.target,
        c = this.categoryAxis;
      if (a.panning) this.handleCursorHide(a);
      else if (this.chartData && !b.isHidden) {
        var d = this.graphs;
        if (d) {
          var g;
          g = c.xToIndex(this.rotate ? a.y : a.x);
          if ((g = this.chartData[g])) {
            var h, f, k, l;
            if (b.oneBalloonOnly) {
              var m = Infinity;
              for (h = 0; h < d.length; h++)
                if (
                  ((f = d[h]), f.balloon.enabled && f.showBalloon && !f.hidden)
                ) {
                  k = f.valueAxis.id;
                  k = g.axes[k].graphs[f.id];
                  k = k.y;
                  "top" == f.showBalloonAt && (k = 0);
                  "bottom" == f.showBalloonAt && (k = this.height);
                  var q = b.mouseX,
                    n = b.mouseY;
                  k = this.rotate ? Math.abs(q - k) : Math.abs(n - k);
                  k < m && ((m = k), (l = f));
                }
              b.mostCloseGraph = l;
            }
            if (this.prevCursorItem != g || l != this.prevMostCloseGraph) {
              m = [];
              for (h = 0; h < d.length; h++)
                (f = d[h]),
                  (k = f.valueAxis.id),
                  (k = g.axes[k].graphs[f.id]),
                  b.showNextAvailable &&
                    isNaN(k.y) &&
                    (k = this.getNextItem(k)),
                  l && f != l
                    ? (f.showGraphBalloon(
                        k,
                        b.pointer,
                        !1,
                        b.graphBulletSize,
                        b.graphBulletAlpha
                      ),
                      f.balloon.hide(0))
                    : b.valueBalloonsEnabled
                    ? ((f.balloon.showBullet = b.bulletsEnabled),
                      (f.balloon.bulletSize = b.bulletSize / 2),
                      a.hideBalloons ||
                        (f.showGraphBalloon(
                          k,
                          b.pointer,
                          !1,
                          b.graphBulletSize,
                          b.graphBulletAlpha
                        ),
                        f.balloon.set &&
                          m.push({
                            balloon: f.balloon,
                            y: f.balloon.pointToY,
                          })))
                    : ((f.currentDataItem = k),
                      f.resizeBullet(k, b.graphBulletSize, b.graphBulletAlpha));
              b.avoidBalloonOverlapping && this.arrangeBalloons(m);
              this.prevCursorItem = g;
            }
            this.prevMostCloseGraph = l;
          }
        }
        c.showBalloon(a.x, a.y, b.categoryBalloonDateFormat, a.skip);
        this.updateLegendValues();
      }
    },
    handleCursorHide: function (a) {
      e.AmSerialChart.base.handleCursorHide.call(this, a);
      a = this.categoryAxis;
      this.prevCursorItem = null;
      this.updateLegendValues();
      a && a.hideBalloon();
      a = this.graphs;
      var b;
      for (b = 0; b < a.length; b++) a[b].currentDataItem = null;
    },
    handleCursorPanning: function (a) {
      var b = a.target,
        c,
        d = a.deltaX,
        g = a.deltaY,
        h = a.delta2X,
        f = a.delta2Y;
      a = !1;
      if (this.rotate) {
        isNaN(h) && ((h = d), (a = !0));
        var k = this.endX0;
        c = this.startX0;
        var l = k - c,
          k = k - l * h,
          m = l;
        a || (m = 0);
        a = e.fitToBounds(c - l * d, 0, 1 - m);
      } else
        isNaN(f) && ((f = g), (a = !0)),
          (k = this.endY0),
          (c = this.startY0),
          (l = k - c),
          (k += l * g),
          (m = l),
          a || (m = 0),
          (a = e.fitToBounds(c + l * f, 0, 1 - m));
      c = e.fitToBounds(k, m, 1);
      var q;
      b.valueZoomable && (q = this.relativeZoomValueAxes(this.valueAxes, a, c));
      var n;
      c = this.categoryAxis;
      this.rotate && ((d = g), (h = f));
      a = !1;
      isNaN(h) && ((h = d), (a = !0));
      if (b.zoomable && (0 < Math.abs(d) || 0 < Math.abs(h)))
        if (c.parseDates && !c.equalSpacing) {
          if (
            ((f = this.startTime0),
            (g = this.endTime0),
            (c = g - f),
            (h *= c),
            (l = this.firstTime),
            (k = this.lastTime),
            (m = c),
            a || (m = 0),
            (a = Math.round(e.fitToBounds(f - c * d, l, k - m))),
            (h = Math.round(e.fitToBounds(g - h, l + m, k))),
            this.startTime != a || this.endTime != h)
          )
            (n = { chart: this, target: b, type: "zoomed", start: a, end: h }),
              (this.skipZoomed = !0),
              b.fire(n),
              this.zoom(a, h),
              (n = !0);
        } else if (
          ((f = this.start0),
          (g = this.end0),
          (c = g - f),
          (d = Math.round(c * d)),
          (h = Math.round(c * h)),
          (l = this.chartData.length - 1),
          a || (c = 0),
          (a = e.fitToBounds(f - d, 0, l - c)),
          (c = e.fitToBounds(g - h, c, l)),
          this.start != a || this.end != c)
        )
          (this.skipZoomed = !0),
            b.fire({
              chart: this,
              target: b,
              type: "zoomed",
              start: a,
              end: c,
            }),
            this.zoom(a, c),
            (n = !0);
      !n && q && this.updateAfterValueZoom();
    },
    arrangeBalloons: function (a) {
      var b = this.plotAreaHeight;
      a.sort(this.compareY);
      var c,
        d,
        e,
        h = this.plotAreaWidth,
        f = a.length;
      for (c = 0; c < f; c++)
        (d = a[c].balloon),
          d.setBounds(0, 0, h, b),
          d.restorePrevious(),
          d.draw(),
          (b = d.yPos - 3);
      a.reverse();
      for (c = 0; c < f; c++) {
        d = a[c].balloon;
        var b = d.bottom,
          k = d.bottom - d.yPos;
        0 < c &&
          b - k < e + 3 &&
          (d.setBounds(0, e + 3, h, e + k + 3), d.restorePrevious(), d.draw());
        d.set && d.set.show();
        e = d.bottom;
      }
    },
    compareY: function (a, b) {
      return a.y < b.y ? 1 : -1;
    },
  });
})();
(function () {
  var e = window.AmCharts;
  e.Cuboid = e.Class({
    construct: function (a, b, c, d, e, h, f, k, l, m, q, n, p, x, u, B, r) {
      this.set = a.set();
      this.container = a;
      this.h = Math.round(c);
      this.w = Math.round(b);
      this.dx = d;
      this.dy = e;
      this.colors = h;
      this.alpha = f;
      this.bwidth = k;
      this.bcolor = l;
      this.balpha = m;
      this.dashLength = x;
      this.topRadius = B;
      this.pattern = u;
      this.rotate = p;
      this.bcn = r;
      p ? 0 > b && 0 === q && (q = 180) : 0 > c && 270 == q && (q = 90);
      this.gradientRotation = q;
      0 === d && 0 === e && (this.cornerRadius = n);
      this.draw();
    },
    draw: function () {
      var a = this.set;
      a.clear();
      var b = this.container,
        c = b.chart,
        d = this.w,
        g = this.h,
        h = this.dx,
        f = this.dy,
        k = this.colors,
        l = this.alpha,
        m = this.bwidth,
        q = this.bcolor,
        n = this.balpha,
        p = this.gradientRotation,
        x = this.cornerRadius,
        u = this.dashLength,
        B = this.pattern,
        r = this.topRadius,
        t = this.bcn,
        C = k,
        v = k;
      "object" == typeof k && ((C = k[0]), (v = k[k.length - 1]));
      var w,
        A,
        z,
        G,
        y,
        D,
        F,
        L,
        M,
        Q = l;
      B && (l = 0);
      var E,
        H,
        I,
        J,
        K = this.rotate;
      if (0 < Math.abs(h) || 0 < Math.abs(f))
        if (isNaN(r))
          (F = v),
            (v = e.adjustLuminosity(C, -0.2)),
            (v = e.adjustLuminosity(C, -0.2)),
            (w = e.polygon(
              b,
              [0, h, d + h, d, 0],
              [0, f, f, 0, 0],
              v,
              l,
              1,
              q,
              0,
              p
            )),
            0 < n && (M = e.line(b, [0, h, d + h], [0, f, f], q, n, m, u)),
            (A = e.polygon(
              b,
              [0, 0, d, d, 0],
              [0, g, g, 0, 0],
              v,
              l,
              1,
              q,
              0,
              p
            )),
            A.translate(h, f),
            0 < n && (z = e.line(b, [h, h], [f, f + g], q, n, m, u)),
            (G = e.polygon(
              b,
              [0, 0, h, h, 0],
              [0, g, g + f, f, 0],
              v,
              l,
              1,
              q,
              0,
              p
            )),
            (y = e.polygon(
              b,
              [d, d, d + h, d + h, d],
              [0, g, g + f, f, 0],
              v,
              l,
              1,
              q,
              0,
              p
            )),
            0 < n &&
              (D = e.line(
                b,
                [d, d + h, d + h, d],
                [0, f, g + f, g],
                q,
                n,
                m,
                u
              )),
            (v = e.adjustLuminosity(F, 0.2)),
            (F = e.polygon(
              b,
              [0, h, d + h, d, 0],
              [g, g + f, g + f, g, g],
              v,
              l,
              1,
              q,
              0,
              p
            )),
            0 < n &&
              (L = e.line(b, [0, h, d + h], [g, g + f, g + f], q, n, m, u));
        else {
          var N, O, P;
          K
            ? ((N = g / 2),
              (v = h / 2),
              (P = g / 2),
              (O = d + h / 2),
              (H = Math.abs(g / 2)),
              (E = Math.abs(h / 2)))
            : ((v = d / 2),
              (N = f / 2),
              (O = d / 2),
              (P = g + f / 2 + 1),
              (E = Math.abs(d / 2)),
              (H = Math.abs(f / 2)));
          I = E * r;
          J = H * r;
          0.1 < E &&
            0.1 < E &&
            ((w = e.circle(b, E, C, l, m, q, n, !1, H)), w.translate(v, N));
          0.1 < I &&
            0.1 < I &&
            ((F = e.circle(
              b,
              I,
              e.adjustLuminosity(C, 0.5),
              l,
              m,
              q,
              n,
              !1,
              J
            )),
            F.translate(O, P));
        }
      l = Q;
      1 > Math.abs(g) && (g = 0);
      1 > Math.abs(d) && (d = 0);
      !isNaN(r) && (0 < Math.abs(h) || 0 < Math.abs(f))
        ? ((k = [C]),
          (k = {
            fill: k,
            stroke: q,
            "stroke-width": m,
            "stroke-opacity": n,
            "fill-opacity": l,
          }),
          K
            ? ((l = "M0,0 L" + d + "," + (g / 2 - (g / 2) * r)),
              (m = " B"),
              0 < d && (m = " A"),
              e.VML
                ? ((l +=
                    m +
                    Math.round(d - I) +
                    "," +
                    Math.round(g / 2 - J) +
                    "," +
                    Math.round(d + I) +
                    "," +
                    Math.round(g / 2 + J) +
                    "," +
                    d +
                    ",0," +
                    d +
                    "," +
                    g),
                  (l =
                    l +
                    (" L0," + g) +
                    (m +
                      Math.round(-E) +
                      "," +
                      Math.round(g / 2 - H) +
                      "," +
                      Math.round(E) +
                      "," +
                      Math.round(g / 2 + H) +
                      ",0," +
                      g +
                      ",0,0")))
                : ((l +=
                    "A" +
                    I +
                    "," +
                    J +
                    ",0,0,0," +
                    d +
                    "," +
                    (g - (g / 2) * (1 - r)) +
                    "L0," +
                    g),
                  (l += "A" + E + "," + H + ",0,0,1,0,0")),
              (E = 90))
            : ((m = d / 2 - (d / 2) * r),
              (l = "M0,0 L" + m + "," + g),
              e.VML
                ? ((l = "M0,0 L" + m + "," + g),
                  (m = " B"),
                  0 > g && (m = " A"),
                  (l +=
                    m +
                    Math.round(d / 2 - I) +
                    "," +
                    Math.round(g - J) +
                    "," +
                    Math.round(d / 2 + I) +
                    "," +
                    Math.round(g + J) +
                    ",0," +
                    g +
                    "," +
                    d +
                    "," +
                    g),
                  (l += " L" + d + ",0"),
                  (l +=
                    m +
                    Math.round(d / 2 + E) +
                    "," +
                    Math.round(H) +
                    "," +
                    Math.round(d / 2 - E) +
                    "," +
                    Math.round(-H) +
                    "," +
                    d +
                    ",0,0,0"))
                : ((l +=
                    "A" +
                    I +
                    "," +
                    J +
                    ",0,0,0," +
                    (d - (d / 2) * (1 - r)) +
                    "," +
                    g +
                    "L" +
                    d +
                    ",0"),
                  (l += "A" + E + "," + H + ",0,0,1,0,0")),
              (E = 180)),
          (b = b.path(l).attr(k)),
          b.gradient(
            "linearGradient",
            [C, e.adjustLuminosity(C, -0.3), e.adjustLuminosity(C, -0.3), C],
            E
          ),
          K ? b.translate(h / 2, 0) : b.translate(0, f / 2))
        : (b =
            0 === g
              ? e.line(b, [0, d], [0, 0], q, n, m, u)
              : 0 === d
              ? e.line(b, [0, 0], [0, g], q, n, m, u)
              : 0 < x
              ? e.rect(b, d, g, k, l, m, q, n, x, p, u)
              : e.polygon(
                  b,
                  [0, 0, d, d, 0],
                  [0, g, g, 0, 0],
                  k,
                  l,
                  m,
                  q,
                  n,
                  p,
                  !1,
                  u
                ));
      d = isNaN(r)
        ? 0 > g
          ? [w, M, A, z, G, y, D, F, L, b]
          : [F, L, A, z, G, y, w, M, D, b]
        : K
        ? 0 < d
          ? [w, b, F]
          : [F, b, w]
        : 0 > g
        ? [w, b, F]
        : [F, b, w];
      e.setCN(c, b, t + "front");
      e.setCN(c, A, t + "back");
      e.setCN(c, F, t + "top");
      e.setCN(c, w, t + "bottom");
      e.setCN(c, G, t + "left");
      e.setCN(c, y, t + "right");
      for (w = 0; w < d.length; w++)
        if ((A = d[w])) a.push(A), e.setCN(c, A, t + "element");
      B && b.pattern(B, NaN, c.path);
    },
    width: function (a) {
      isNaN(a) && (a = 0);
      this.w = Math.round(a);
      this.draw();
    },
    height: function (a) {
      isNaN(a) && (a = 0);
      this.h = Math.round(a);
      this.draw();
    },
    animateHeight: function (a, b) {
      var c = this;
      c.animationFinished = !1;
      c.easing = b;
      c.totalFrames = a * e.updateRate;
      c.rh = c.h;
      c.frame = 0;
      c.height(1);
      setTimeout(function () {
        c.updateHeight.call(c);
      }, 1e3 / e.updateRate);
    },
    updateHeight: function () {
      var a = this;
      a.frame++;
      var b = a.totalFrames;
      a.frame <= b
        ? ((b = a.easing(0, a.frame, 1, a.rh - 1, b)),
          a.height(b),
          window.requestAnimationFrame
            ? window.requestAnimationFrame(function () {
                a.updateHeight.call(a);
              })
            : setTimeout(function () {
                a.updateHeight.call(a);
              }, 1e3 / e.updateRate))
        : (a.height(a.rh), (a.animationFinished = !0));
    },
    animateWidth: function (a, b) {
      var c = this;
      c.animationFinished = !1;
      c.easing = b;
      c.totalFrames = a * e.updateRate;
      c.rw = c.w;
      c.frame = 0;
      c.width(1);
      setTimeout(function () {
        c.updateWidth.call(c);
      }, 1e3 / e.updateRate);
    },
    updateWidth: function () {
      var a = this;
      a.frame++;
      var b = a.totalFrames;
      a.frame <= b
        ? ((b = a.easing(0, a.frame, 1, a.rw - 1, b)),
          a.width(b),
          window.requestAnimationFrame
            ? window.requestAnimationFrame(function () {
                a.updateWidth.call(a);
              })
            : setTimeout(function () {
                a.updateWidth.call(a);
              }, 1e3 / e.updateRate))
        : (a.width(a.rw), (a.animationFinished = !0));
    },
  });
})();
(function () {
  var e = window.AmCharts;
  e.CategoryAxis = e.Class({
    inherits: e.AxisBase,
    construct: function (a) {
      this.cname = "CategoryAxis";
      e.CategoryAxis.base.construct.call(this, a);
      this.minPeriod = "DD";
      this.equalSpacing = this.parseDates = !1;
      this.position = "bottom";
      this.startOnAxis = !1;
      this.gridPosition = "middle";
      this.safeDistance = 30;
      this.stickBalloonToCategory = !1;
      e.applyTheme(this, a, this.cname);
    },
    draw: function () {
      e.CategoryAxis.base.draw.call(this);
      this.generateDFObject();
      var a = this.chart.chartData;
      this.data = a;
      this.labelRotationR = this.labelRotation;
      this.type = null;
      if (e.ifArray(a)) {
        var b,
          c = this.chart;
        "scrollbar" != this.id
          ? (e.setCN(c, this.set, "category-axis"),
            e.setCN(c, this.labelsSet, "category-axis"),
            e.setCN(c, this.axisLine.axisSet, "category-axis"))
          : (this.bcn = this.id + "-");
        var d = this.start,
          g = this.labelFrequency,
          h = 0,
          f = this.end - d + 1,
          k = this.gridCountR,
          l = this.showFirstLabel,
          m = this.showLastLabel,
          q,
          n,
          p = "",
          p = e.extractPeriod(this.minPeriod),
          x = e.getPeriodDuration(p.period, p.count),
          u,
          B,
          r,
          t,
          C = this.rotate;
        q = this.firstDayOfWeek;
        n = this.boldPeriodBeginning;
        b = e
          .resetDateToMin(
            new Date(a[a.length - 1].time + 1.05 * x),
            this.minPeriod,
            1,
            q
          )
          .getTime();
        this.firstTime = c.firstTime;
        this.endTime > b && (this.endTime = b);
        t = this.minorGridEnabled;
        B = this.gridAlpha;
        var v,
          w = 0,
          A = 0;
        if (this.widthField)
          for (b = this.start; b <= this.end; b++)
            if ((v = this.data[b])) {
              var z = Number(this.data[b].dataContext[this.widthField]);
              isNaN(z) || ((w += z), (v.widthValue = z));
            }
        if (this.parseDates && !this.equalSpacing)
          (this.lastTime = a[a.length - 1].time),
            (this.maxTime = e
              .resetDateToMin(
                new Date(this.lastTime + 1.05 * x),
                this.minPeriod,
                1,
                q
              )
              .getTime()),
            (this.timeDifference = this.endTime - this.startTime),
            this.parseDatesDraw();
        else if (!this.parseDates) {
          if (
            ((this.cellWidth = this.getStepWidth(f)),
            f < k && (k = f),
            (h += this.start),
            (this.stepWidth = this.getStepWidth(f)),
            0 < k)
          )
            for (
              k = Math.floor(f / k),
                f = this.chooseMinorFrequency(k),
                p = h,
                p / 2 == Math.round(p / 2) && p--,
                0 > p && (p = 0),
                v = 0,
                this.widthField && (p = this.start),
                this.end - p + 1 >= this.autoRotateCount &&
                  (this.labelRotationR = this.autoRotateAngle),
                b = p;
              b <= this.end + 2;
              b++
            ) {
              n = !1;
              0 <= b && b < this.data.length
                ? ((u = this.data[b]), (p = u.category), (n = u.forceShow))
                : (p = "");
              if (t && !isNaN(f))
                if (b / f == Math.round(b / f) || n)
                  b / k == Math.round(b / k) ||
                    n ||
                    ((this.gridAlpha = this.minorGridAlpha), (p = void 0));
                else continue;
              else if (b / k != Math.round(b / k) && !n) continue;
              q = this.getCoordinate(b - h);
              r = 0;
              "start" == this.gridPosition &&
                ((q -= this.cellWidth / 2), (r = this.cellWidth / 2));
              n = !0;
              a = r;
              "start" == this.tickPosition && ((a = 0), (n = !1), (r = 0));
              if ((b == d && !l) || (b == this.end && !m)) p = void 0;
              Math.round(v / g) != v / g && (p = void 0);
              v++;
              z = this.cellWidth;
              C &&
                ((z = NaN), this.ignoreAxisWidth || !c.autoMargins) &&
                ((z = "right" == this.position ? c.marginRight : c.marginLeft),
                (z -= this.tickLength + 10));
              this.labelFunction && u && (p = this.labelFunction(p, u, this));
              p = e.fixBrakes(p);
              x = !1;
              this.boldLabels && (x = !0);
              b > this.end && "start" == this.tickPosition && (p = " ");
              this.rotate && this.inside && (r -= 2);
              isNaN(u.widthValue) ||
                ((u.percentWidthValue = (u.widthValue / w) * 100),
                (z = this.rotate
                  ? (this.height * u.widthValue) / w
                  : (this.width * u.widthValue) / w),
                (q = A),
                (A += z),
                (r = z / 2));
              r = new this.axisItemRenderer(
                this,
                q,
                p,
                n,
                z,
                r,
                void 0,
                x,
                a,
                !1,
                u.labelColor,
                u.className
              );
              r.serialDataItem = u;
              this.pushAxisItem(r);
              this.gridAlpha = B;
            }
        } else if (this.parseDates && this.equalSpacing) {
          h = this.start;
          this.startTime = this.data[this.start].time;
          this.endTime = this.data[this.end].time;
          this.timeDifference = this.endTime - this.startTime;
          b = this.choosePeriod(0);
          g = b.period;
          u = b.count;
          b = e.getPeriodDuration(g, u);
          b < x && ((g = p.period), (u = p.count), (b = x));
          B = g;
          "WW" == B && (B = "DD");
          this.currentDateFormat = this.dateFormatsObject[B];
          this.stepWidth = this.getStepWidth(f);
          k = Math.ceil(this.timeDifference / b) + 1;
          x = e.resetDateToMin(new Date(this.startTime - b), g, u, q).getTime();
          this.cellWidth = this.getStepWidth(f);
          p = Math.round(x / b);
          d = -1;
          p / 2 == Math.round(p / 2) && ((d = -2), (x -= b));
          p = this.start;
          p / 2 == Math.round(p / 2) && p--;
          0 > p && (p = 0);
          A = this.end + 2;
          A >= this.data.length && (A = this.data.length);
          v = !1;
          v = !l;
          this.previousPos = -1e3;
          20 < this.labelRotationR && (this.safeDistance = 5);
          a = p;
          if (
            this.data[p].time !=
            e.resetDateToMin(new Date(this.data[p].time), g, u, q).getTime()
          )
            for (q = 0, z = x, b = p; b < A; b++)
              (f = this.data[b].time),
                this.checkPeriodChange(g, u, f, z) &&
                  (q++, 2 <= q && ((a = b), (b = A)), (z = f));
          t &&
            1 < u &&
            ((f = this.chooseMinorFrequency(u)), e.getPeriodDuration(g, f));
          if (0 < this.gridCountR)
            for (b = p; b < A; b++)
              if (
                ((f = this.data[b].time),
                this.checkPeriodChange(g, u, f, x) && b >= a)
              ) {
                q = this.getCoordinate(b - this.start);
                t = !1;
                this.nextPeriod[B] &&
                  (t = this.checkPeriodChange(this.nextPeriod[B], 1, f, x, B));
                x = !1;
                t && this.markPeriodChange
                  ? ((t = this.dateFormatsObject[this.nextPeriod[B]]), (x = !0))
                  : (t = this.dateFormatsObject[B]);
                p = e.formatDate(new Date(f), t, c);
                if ((b == d && !l) || (b == k && !m)) p = " ";
                v
                  ? (v = !1)
                  : (n || (x = !1),
                    q - this.previousPos >
                      this.safeDistance *
                        Math.cos((this.labelRotationR * Math.PI) / 180) &&
                      (this.labelFunction &&
                        (p = this.labelFunction(p, new Date(f), this, g, u, r)),
                      this.boldLabels && (x = !0),
                      (r = new this.axisItemRenderer(
                        this,
                        q,
                        p,
                        void 0,
                        void 0,
                        void 0,
                        void 0,
                        x
                      )),
                      (t = r.graphics()),
                      this.pushAxisItem(r),
                      (t = t.getBBox().width),
                      e.isModern || (t -= q),
                      (this.previousPos = q + t)));
                r = x = f;
              }
        }
        for (b = l = 0; b < this.data.length; b++)
          if ((v = this.data[b]))
            this.parseDates && !this.equalSpacing
              ? ((m = v.time),
                (d = this.cellWidth),
                "MM" == this.minPeriod &&
                  ((d = 864e5 * e.daysInMonth(new Date(m)) * this.stepWidth),
                  (v.cellWidth = d)),
                (m = Math.round((m - this.startTime) * this.stepWidth + d / 2)))
              : (m = this.getCoordinate(b - h)),
              (v.x[this.id] = m);
        if (this.widthField)
          for (b = this.start; b <= this.end; b++)
            (v = this.data[b]),
              (d = v.widthValue),
              (v.percentWidthValue = (d / w) * 100),
              this.rotate
                ? ((m = (this.height * d) / w / 2 + l),
                  (l = (this.height * d) / w + l))
                : ((m = (this.width * d) / w / 2 + l),
                  (l = (this.width * d) / w + l)),
              (v.x[this.id] = m);
        w = this.guides.length;
        for (b = 0; b < w; b++)
          (l = this.guides[b]),
            (n = k = k = t = d = NaN),
            (m = l.above),
            l.toCategory &&
              ((k = c.getCategoryIndexByValue(l.toCategory)),
              isNaN(k) ||
                ((d = this.getCoordinate(k - h)),
                l.expand && (d += this.cellWidth / 2),
                (r = new this.axisItemRenderer(this, d, "", !0, NaN, NaN, l)),
                this.pushAxisItem(r, m))),
            l.category &&
              ((n = c.getCategoryIndexByValue(l.category)),
              isNaN(n) ||
                ((t = this.getCoordinate(n - h)),
                l.expand && (t -= this.cellWidth / 2),
                (k = (d - t) / 2),
                (r = new this.axisItemRenderer(
                  this,
                  t,
                  l.label,
                  !0,
                  NaN,
                  k,
                  l
                )),
                this.pushAxisItem(r, m))),
            (n = c.dataDateFormat),
            l.toDate &&
              (!n ||
                l.toDate instanceof Date ||
                (l.toDate = l.toDate.toString() + " |"),
              (l.toDate = e.getDate(l.toDate, n)),
              this.equalSpacing
                ? ((k = c.getClosestIndex(
                    this.data,
                    "time",
                    l.toDate.getTime(),
                    !1,
                    0,
                    this.data.length - 1
                  )),
                  isNaN(k) || (d = this.getCoordinate(k - h)))
                : (d = (l.toDate.getTime() - this.startTime) * this.stepWidth),
              (r = new this.axisItemRenderer(this, d, "", !0, NaN, NaN, l)),
              this.pushAxisItem(r, m)),
            l.date &&
              (!n ||
                l.date instanceof Date ||
                (l.date = l.date.toString() + " |"),
              (l.date = e.getDate(l.date, n)),
              this.equalSpacing
                ? ((n = c.getClosestIndex(
                    this.data,
                    "time",
                    l.date.getTime(),
                    !1,
                    0,
                    this.data.length - 1
                  )),
                  isNaN(n) || (t = this.getCoordinate(n - h)))
                : (t = (l.date.getTime() - this.startTime) * this.stepWidth),
              (k = (d - t) / 2),
              (n = !0),
              l.toDate && (n = !1),
              (r =
                "H" == this.orientation
                  ? new this.axisItemRenderer(
                      this,
                      t,
                      l.label,
                      n,
                      2 * k,
                      NaN,
                      l
                    )
                  : new this.axisItemRenderer(this, t, l.label, !1, NaN, k, l)),
              this.pushAxisItem(r, m)),
            (0 < d || 0 < t) &&
              (d < this.width || t < this.width) &&
              ((d = new this.guideFillRenderer(this, t, d, l)),
              (t = d.graphics()),
              this.pushAxisItem(d, m),
              (l.graphics = t),
              (t.index = b),
              l.balloonText && this.addEventListeners(t, l));
        if ((c = c.chartCursor))
          C
            ? c.fixHeight(this.cellWidth)
            : (c.fixWidth(this.cellWidth),
              c.fullWidth &&
                this.balloon &&
                (this.balloon.minWidth = this.cellWidth));
        this.previousHeight = G;
      }
      this.axisCreated = !0;
      this.set.translate(this.x, this.y);
      this.labelsSet.translate(this.x, this.y);
      this.labelsSet.show();
      this.positionTitle();
      (C = this.axisLine.set) && C.toFront();
      var G = this.getBBox().height;
      2 < G - this.previousHeight &&
        this.autoWrap &&
        !this.parseDates &&
        (this.axisCreated = this.chart.marginsUpdated = !1);
    },
    xToIndex: function (a) {
      var b = this.data,
        c = this.chart,
        d = c.rotate,
        g = this.stepWidth,
        h;
      if (this.parseDates && !this.equalSpacing)
        (a = this.startTime + Math.round(a / g) - this.minDuration() / 2),
          (h = c.getClosestIndex(b, "time", a, !1, this.start, this.end + 1));
      else if (this.widthField)
        for (c = Infinity, g = this.start; g <= this.end; g++) {
          var f = this.data[g];
          f && ((f = Math.abs(f.x[this.id] - a)), f < c && ((c = f), (h = g)));
        }
      else
        this.startOnAxis || (a -= g / 2), (h = this.start + Math.round(a / g));
      h = e.fitToBounds(h, 0, b.length - 1);
      var k;
      b[h] && (k = b[h].x[this.id]);
      d ? k > this.height + 1 && h-- : k > this.width + 1 && h--;
      0 > k && h++;
      return (h = e.fitToBounds(h, 0, b.length - 1));
    },
    dateToCoordinate: function (a) {
      return this.parseDates && !this.equalSpacing
        ? (a.getTime() - this.startTime) * this.stepWidth
        : this.parseDates && this.equalSpacing
        ? ((a = this.chart.getClosestIndex(
            this.data,
            "time",
            a.getTime(),
            !1,
            0,
            this.data.length - 1
          )),
          this.getCoordinate(a - this.start))
        : NaN;
    },
    categoryToCoordinate: function (a) {
      if (this.chart) {
        var b = this.chart.getCategoryIndexByValue(a);
        if (!isNaN(b)) return this.getCoordinate(b - this.start);
        if (this.parseDates) return this.dateToCoordinate(new Date(a));
      } else return NaN;
    },
    coordinateToDate: function (a) {
      return this.equalSpacing
        ? ((a = this.xToIndex(a)), new Date(this.data[a].time))
        : new Date(this.startTime + a / this.stepWidth);
    },
    coordinateToValue: function (a) {
      a = this.xToIndex(a);
      if ((a = this.data[a])) return this.parseDates ? a.time : a.category;
    },
    getCoordinate: function (a) {
      a *= this.stepWidth;
      this.startOnAxis || (a += this.stepWidth / 2);
      return Math.round(a);
    },
    formatValue: function (a, b) {
      b || (b = this.currentDateFormat);
      this.parseDates && (a = e.formatDate(new Date(a), b, this.chart));
      return a;
    },
    showBalloonAt: function (a) {
      a = this.parseDates
        ? this.dateToCoordinate(new Date(a))
        : this.categoryToCoordinate(a);
      return this.adjustBalloonCoordinate(a);
    },
    formatBalloonText: function (a, b, c) {
      var d = "",
        g = "",
        h = this.chart,
        f = this.data[b];
      if (f)
        if (this.parseDates)
          (d = e.formatDate(f.category, c, h)),
            (b = e.changeDate(new Date(f.category), this.minPeriod, 1)),
            (g = e.formatDate(b, c, h)),
            -1 != d.indexOf("fff") &&
              ((d = e.formatMilliseconds(d, f.category)),
              (g = e.formatMilliseconds(g, b)));
        else {
          var k;
          this.data[b + 1] && (k = this.data[b + 1]);
          d = e.fixNewLines(f.category);
          k && (g = e.fixNewLines(k.category));
        }
      a = a.replace(/\[\[category\]\]/g, String(d));
      return (a = a.replace(/\[\[toCategory\]\]/g, String(g)));
    },
    adjustBalloonCoordinate: function (a, b) {
      var c = this.xToIndex(a),
        d = this.chart.chartCursor;
      if (this.stickBalloonToCategory) {
        var e = this.data[c];
        e && (a = e.x[this.id]);
        this.stickBalloonToStart && (a -= this.cellWidth / 2);
        var h = 0;
        if (d) {
          var f = d.limitToGraph;
          f && (h = e.axes[f.valueAxis.id].graphs[f.id].y);
          this.rotate
            ? ("left" == this.position
                ? (f && (h -= d.width), 0 < h && (h = 0))
                : 0 > h && (h = 0),
              d.fixHLine(a, h))
            : ("top" == this.position
                ? (f && (h -= d.height), 0 < h && (h = 0))
                : 0 > h && (h = 0),
              d.fixVLine(a, h));
        }
      }
      d &&
        !b &&
        (d.setIndex(c),
        this.parseDates && d.setTimestamp(this.coordinateToDate(a).getTime()));
      return a;
    },
  });
})();
