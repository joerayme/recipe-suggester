# Recipe Suggester

A small CLI utility to take a list of ingredients, a set of recipes and suggest which recipes to make based on the list of available ingredients.

## Installation

Use [Composer](https://getcomposer.org) to install the project's dependencies:

`php composer.phar install`

## Usage

`php recipesuggest.php <recipes file> <ingredients file>`

## Todo

* Add more little logic to validate arguments in classes
* Test with large sets and potentially limit the size of input files for performance
* Input files are read all as one at the moment - for large data sets, reading a stream would be faster (although difficult to do with JSON format and builtins)
* Make CLI a bit nicer - add colours, better help text, validation etc.
* Automatically detect file types for input files and switch parser depending on type
* Only show the out-of-date ingredient error message once per item
