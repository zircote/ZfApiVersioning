# Docs and Info coming soon...

This is very much a work in progress and proof of concept exploration. It is possible it will die on the vine or be transformed to a production implementation based on my findings.

### Todo
 * Add a pagination Action Helper
 * Add a header Action Helper
 * Add a sorting Action Helper
 * Add an oauth/authentication plugins

### Scheme
_Define reserved words_:

 * `/{$resource}?q=search+something` || `/{$resource}?search=search+something`
 * `/{$resource}?fields=id,firstName,lastName,email`
 * `/{$resource}/count` returns record count for the resource
 * `/{$resource}?method=post|put|delete`
 * `/{$resource}?start=#&count=#` || `/{$resource}?page=#&count=#` || `/{$resource}?limit=#&offset=#`

_Other Items under consideration_:

 * `/{$resource}.json` || `Accept: application/json` || `/{$resource}?format=json`
 * Configurable defaults via `Zircote_Application_Resource_Restendpoint`
   * limits
   * count
   * type
 * `/{$resource}?suppress_response_codes=true`
   * `200 OK` => however retain true error code in the error doc.
 * _Response Header_: `Allow: GET, POST, PUT, DELETE`
 * _Response Header_: `Accept: application/json, applicaiton/xml`
 * _Response Header_: `Content-Type: application/json; charset=UTF8`
 * _Response Header_: `Last-Modified: Tue, 15 Nov 1994 12:45:26 GMT` => Updated field of record
 * _Response Header_: `Range: 21010-47021/47022`
   * The presence of a Range header in an unconditional GET modifies what is returned if the GET is otherwise successful. In other words, the response carries a status code of 206 (Partial Content) instead of 200 (OK).


