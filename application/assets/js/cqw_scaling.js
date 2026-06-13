/**
 * Content Block CQW (container-query-width) Scaling utilities.
 *
 * Exposes pure utility functions extracted from editor.js so they can be
 * loaded independently and toggled on/off without touching the main IIFE.
 *
 * Load this file BEFORE editor.js. editor.js delegates to window.CbCqwScaling
 * when present; when absent it falls back to inline no-op behaviour.
 *
 * @namespace window.CbCqwScaling
 */
window.CbCqwScaling = (function () {
  "use strict";

  /**
   * Normalize Pixel Width List.
   * Parses a comma-separated string or array of pixel threshold values,
   * validates that all values are positive integers, deduplicates, and
   * returns them sorted in descending order. Returns null on invalid input.
   *
   * @param {string|Array|null|undefined} pvalue
   * @returns {number[]|null}
   */
  function fnNormalizePixelWidthList(pvalue) {
    if (pvalue === "" || pvalue === null || pvalue === undefined) return null;
    var arrRaw = Array.isArray(pvalue)
      ? pvalue
      : String(pvalue || "")
          .split(",")
          .map(function (strPart) {
            return strPart.trim();
          })
          .filter(Boolean);
    if (!arrRaw.length) return null;
    var arrValues = arrRaw.map(function (mxValue) {
      return Math.floor(Number(mxValue));
    });
    var objSeen = {};
    if (
      arrValues.some(function (iValue) {
        return !Number.isFinite(iValue) || iValue <= 0;
      })
    )
      return null;
    return arrValues
      .filter(function (iValue) {
        if (objSeen[iValue]) return false;
        objSeen[iValue] = true;
        return true;
      })
      .sort(function (iLeft, iRight) {
        return iRight - iLeft;
      });
  }

  /**
   * Format Pixel Width List.
   * Returns a comma-separated display string from a pixel width list value,
   * or an empty string if the value is invalid.
   *
   * @param {string|Array|null|undefined} pvalue
   * @returns {string}
   */
  function fnFormatPixelWidthList(pvalue) {
    var arrValues = fnNormalizePixelWidthList(pvalue);
    return arrValues ? arrValues.join(", ") : "";
  }

  /**
   * Scale CSS px lengths to cqw against a reference width.
   * Rewrites every `px` length in the rule string to a `cqw` value so that
   * 100 cqw of the stage maps back to the authored pixel size. Percentages,
   * transforms, and unitless values (z-index, aspect-ratio) are left untouched.
   *
   * @param {string} pstrRule         A CSS rule or declaration string.
   * @param {number} piReferenceWidth The authored stage width in px (divisor).
   * @returns {string}
   */
  function fnScaleCssPxToCqw(pstrRule, piReferenceWidth) {
    var iReferenceWidth = Number(piReferenceWidth);
    if (!(iReferenceWidth > 0)) return pstrRule;
    return String(pstrRule).replace(
      /(-?\d*\.?\d+)px/g,
      function (strMatch, strNumber) {
        var fltCqw = (Number(strNumber) / iReferenceWidth) * 100;
        if (!isFinite(fltCqw)) return strMatch;
        return Math.round(fltCqw * 1000) / 1000 + "cqw";
      },
    );
  }

  return {
    fnNormalizePixelWidthList: fnNormalizePixelWidthList,
    fnFormatPixelWidthList: fnFormatPixelWidthList,
    fnScaleCssPxToCqw: fnScaleCssPxToCqw,
  };
})();
