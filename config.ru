require 'rack-rewrite'
require 'rack-legacy'

use Rack::Legacy::Php, "public/"
use Rack::Legacy::Cgi, "public/cgi-bin"
run Rack::File.new("public/")

