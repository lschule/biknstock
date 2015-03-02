# Chart.js

*Simple HTML5 Charts using the canvas element* [chartjs.org](http://www.chartjs.org)

##New Features In This Fork
 - labelsFilter to filter x-axis labels based on user provided function [http://jsfiddle.net/leighking2/mea767ss](http://jsfiddle.net/leighking2/mea767ss/)
 - Template interpolator can be changed from default `<%` `%>` to what ever you want [http://jsfiddle.net/leighking2/d5yq9x32](http://fiddle.jshell.net/leighking2/d5yq9x32/)
 - New chart - overlay chart - for combing both bar and line charts on the same chart [http://jsfiddle.net/leighking2/y58n7m3z](http://fiddle.jshell.net/leighking2/y58n7m3z/)
 - new chart options for pie and dougnut to allow the creation of semi circle (or any size) charts drawn at user defined starting angle [http://jsfiddle.net/leighking2/f62Lghy1](http://fiddle.jshell.net/leighking2/f62Lghy1/)
 - line and overlay charts can handle sparse datasets, just include null in the dataset where no data is avaliable, this can be seen in the samples [http://jsfiddle.net/leighking2/ntuwuk5v](http://fiddle.jshell.net/leighking2/ntuwuk5v/)
 - line,bar and overlay charts can have the tooltip display finely tuned. For each dataset an option called showTooltip can be passed to turn off the displaying off tooltips for that one dataset but not the whole chart [http://jsfiddle.net/leighking2/at3w2aej](http://fiddle.jshell.net/leighking2/at3w2aej/)
 - bar (and overlay) chart can have an option passed to overlay bars (draw on top of each other), just pass the option `overlayBars:true` when creating the chart [http://jsfiddle.net/leighking2/h2f7rs8d/](http://jsfiddle.net/leighking2/h2f7rs8d/)
 - line (and overlay) chart can have an option passed to populate sparse data sets. When this is passed the chart will connect any blank values in the chart so that the line is continous (starts at the first data poitn entered and goes untill the last data point), just pass the option `populateSparseData:true` when creating the chart. [http://jsfiddle.net/leighking2/uhs6rbt8/](http://jsfiddle.net/leighking2/uhs6rbt8/)
 - line,bar and overlay charts have a new option called `labelLength`. This is a number,which if greater than 0, will trim x-axis labels to a specific length [http://fiddle.jshell.net/leighking2/vepoxa54/](http://fiddle.jshell.net/leighking2/vepoxa54/)

All new features are documented in the forks docs section or follow the links to the fiddles to see a working example.
## Documentation

You can find documentation at [chartjs.org/docs](http://www.chartjs.org/docs/). The markdown files that build the site are available under `/docs`. Please note - in some of the json examples of configuration you might notice some liquid tags - this is just for the generating the site html, please disregard.

## License

Chart.js is available under the [MIT license](http://opensource.org/licenses/MIT).

## Bugs & issues

When reporting bugs or issues, if you could include a link to a simple [jsbin](http://jsbin.com) or similar demonstrating the issue, that'd be really helpful.


## Contributing
New contributions to the library are welcome, just a couple of guidelines:

- Tabs for indentation, not spaces please.
- Please ensure you're changing the individual files in `/src`, not the concatenated output in the `Chart.js` file in the root of the repo.
- Please check that your code will pass `jshint` code standards, `gulp jshint` will run this for you.
- Please keep pull requests concise, and document new functionality in the relevant `.md` file.
- Consider whether your changes are useful for all users, or if creating a Chart.js extension would be more appropriate.
- Please avoid committing in the build Chart.js & Chart.min.js file, as it causes conflicts when merging.


