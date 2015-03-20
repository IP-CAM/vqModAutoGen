The vq mod auto gen was created to simplify the creation of vq mod xml files.

This is a command line utility that can be called in the following manner

> php aScript.php -fTheXmlFileToBeWritten -iTheIdOfTheMod -vTheVersionOfTheMod

 - IMPORTANT - The script and class must be in the vqmod directory of opencart.

An example of how the auto gen class can be used is shown below.

include_once('vqAutoGen.php');

$vqAutoGen = new vqAutoGen();
$options   = getopt("f::i::v::");
$vqAutoGen->setOptions($options);
$generatedXml = $vqAutoGen->replace('return $url;', 'return "#";', 'system/library/url.php')->generateXml();
$vqAutoGen->writeXml($generatedXml);

The vqAutoGen() class accepts two parameters, the first is to specify the xml file to write, and the second is to specify the default file name any operations will be applied against.

These are optional parameters but if the default file name is not set then the file name will need to be specified in each function call.

The available operations are as follows:
 - replace()
 - addBefore()
 - addAfter()
 - addInlineBefore()
 - addInlineAfter()
 - top()
 - bottom()

 Each function takes in three parameters the first is the string to be searched for in the file.
 The second parameter is the string to replace what was searched for.
 The third parameter is optional and it supplies the file that the opperation will be associated against. If no parameter is supplied then the default value will be used.

 Once all operations have been implemented a call to generateXml() is required to create the xml string. This is passed into writeXml() as the first parameter, an optional second parameter to set the filename to write to can be used.