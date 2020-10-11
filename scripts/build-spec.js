var JsonRefs = require('json-refs');
var PathLoader = require('path-loader');
var YAML = require('js-yaml');
var fs = require('fs');

var root = YAML.load(fs.readFileSync('../spec/api.yaml').toString());

var options = {
 loaderOptions: {
     processContent: function (res, callback) {
         callback(YAML.safeLoad(res.text));
     }
 },
 location: '../spec/api.yaml'
};

JsonRefs.resolveRefs(root, options).then(function (results) {
   var dir = '../spec/dist';
   if (!fs.existsSync(dir)){
       fs.mkdirSync(dir);
   }

   fs.writeFileSync('../spec/dist/api.yaml', YAML.dump(results.resolved), function(err) {
       if(err) {
           return console.log(err);
       }

       console.log('Specification compiled successfully.');
   });
}, function(err) {
 console.log(err);
});
