## Task #1
Add validation that checks:

1. `$title` and `$message` both have a minimum length of 3.
1. `title`  has a maximum length of 32 characters.
1. `$message` has a maximum length of 52 characters.

If any of the three validation rules fail, print a status of 432 and an error message of what is wrong with the user input. The JSON response should look like:


	{“status”: 432, “error”: “title field is too short”}


If the user submitted a successful post, save the record using the provided `Thread` class. Set the timeposted set to when the item was submitted. Make the thread visible as soon as its submitted. Print a status code of 200. The JSON response should look like:

	{“status”: 200}

Add your code to __newthread.php__. Test your script by running:

    php newthread.php "My Title Here" "My Message here"

## Task #2

Using the provided `Thread` class, show a list of the 3 most recent visible threads sorted to show the most recently created threads first. Print a JSON response with `status` code 200 and an array of `threads` with `threadid, title, message` and `timeposted` fields.

_HINT: You can nest an array within an array in PHP_

Add your code to __threadlist.php__. Test your script by running:

    php threadlist.php

## Task #3
Enhance the code you wrote in Task #2 by replacing any banned words in the message variable for each thread with ****. The banned words are provided in a string `$bannedWords`. 

_HINT: Pay attention to what delimits the words, not the words themselves._

## Bonus Task #1
Using the code from Task #1, convert all urls in the `$message` to HTML links and store the new result as message_html using the provided `Thread` class.

_HINT: You'll need to modify the provided `Thread` class._

## Bonus Task #2
Modify the code from Task #1 to support input via a HTML form submission instead of through the command line.

## Bonus Task #3
Add support to the code to support using a database such as MySQL, instead of the provided `DatabaseFile`.