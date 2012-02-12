# Docs and Info coming soon...

This is very much a work in progress and proof of concept exploration. It is possible it will die on the vine or be transformed to a production implementation based on my findings.

### Todo
 * Add a pagination Action Helper
 * Add a header Action Helper
 * Add a sorting Action Helper
 * Add an oauth/authentication plugins

### Scheme
 * Define reserved words
  * `?q=search+something` | `?search=search+something`
  * `fields`
  * `/{$resource}/count` returns record count for the resource
  * `method`: `?method=post|put|delete`
  * `start` & `count` || `page` & `count` || `limit` & `offset`
  * `/{$resource}.json` || `Accept: application/json` || `?format=json`
  * Configurable defaults via `Zircote_Application_Resource_Restendpoint`
    * limits
    * count
    * type
  * `Last-Modified: Tue, 15 Nov 1994 12:45:26 GMT` => Updated field of record
  * `If-Modified-Since: Sat, 29 Oct 1994 19:43:31 GMT` ???
  * `Range: 21010-47021/47022`
    * The presence of a Range header in an unconditional GET modifies what is returned if the GET is otherwise successful. In other words, the response carries a status code of 206 (Partial Content) instead of 200 (OK).
  * `?suppress_response_codes=true`
    * `200 OK` => however retain true error code in the error doc.


