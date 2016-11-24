# gen-SparkPost-Lists
Simple command-line tool to create example, randomised Suppression and Recipient Lists for import into SparkPost (in .CSV format).

This is useful for any testing that requires lists of specified size, as the email-address uniqueness is checked and enforced.
Redirect output to a file with >myfile.csv, then upload the file using the SparkPost web user interface.

## Usage

```bash
NAME
   ./gen-sparkpost-lists.php
   Generate a random, SparkPost-compatible Recipient- or Suppression-List for .CSV import.

SYNOPSIS
  ./gen-sparkpost-lists.php recip|supp|help [count [domain]]

OPTIONAL PARAMETERS
    count = number of records to generate (default 10)
    domain = recipient domain to generate records for (default sedemo.sink.sparkpostmail.com)
```

##Example output

```bash
./gen-sparkpost-lists.php recip 10 
email,name,return_path,metadata,substitution_data,tags
anon45647117@sedemo.sink.sparkpostmail.com,"Fred Bloggs",bounce@sedemo.sink.sparkpostmail.com,"{""foo"": ""bar""}","{""member"": ""Platinum"", ""region"": ""US""}",
anon16733324@sedemo.sink.sparkpostmail.com,"Fred Bloggs",bounce@sedemo.sink.sparkpostmail.com,"{""foo"": ""bar""}","{""member"": ""Platinum"", ""region"": ""US""}",
anon77744262@sedemo.sink.sparkpostmail.com,"Fred Bloggs",bounce@sedemo.sink.sparkpostmail.com,"{""foo"": ""bar""}","{""member"": ""Platinum"", ""region"": ""US""}",
anon29148022@sedemo.sink.sparkpostmail.com,"Fred Bloggs",bounce@sedemo.sink.sparkpostmail.com,"{""foo"": ""bar""}","{""member"": ""Platinum"", ""region"": ""US""}",
anon01043286@sedemo.sink.sparkpostmail.com,"Fred Bloggs",bounce@sedemo.sink.sparkpostmail.com,"{""foo"": ""bar""}","{""member"": ""Platinum"", ""region"": ""US""}",
anon38310735@sedemo.sink.sparkpostmail.com,"Fred Bloggs",bounce@sedemo.sink.sparkpostmail.com,"{""foo"": ""bar""}","{""member"": ""Platinum"", ""region"": ""US""}",
anon30810724@sedemo.sink.sparkpostmail.com,"Fred Bloggs",bounce@sedemo.sink.sparkpostmail.com,"{""foo"": ""bar""}","{""member"": ""Platinum"", ""region"": ""US""}",
anon89651181@sedemo.sink.sparkpostmail.com,"Fred Bloggs",bounce@sedemo.sink.sparkpostmail.com,"{""foo"": ""bar""}","{""member"": ""Platinum"", ""region"": ""US""}",
anon52939679@sedemo.sink.sparkpostmail.com,"Fred Bloggs",bounce@sedemo.sink.sparkpostmail.com,"{""foo"": ""bar""}","{""member"": ""Platinum"", ""region"": ""US""}",
anon54639748@sedemo.sink.sparkpostmail.com,"Fred Bloggs",bounce@sedemo.sink.sparkpostmail.com,"{""foo"": ""bar""}","{""member"": ""Platinum"", ""region"": ""US""}",
```

##Importing your lists
See the following support articles:

[Using Suppression Lists](https://support.sparkpost.com/customer/portal/articles/1929891)

[Uploading and Storing a Recipient List as a CSV file](https://support.sparkpost.com/customer/portal/articles/2351320)

##How do I modify user data, e.g. name, return_path, metadata, substitution_data, tags?
This is not command-line parameterized, but the code is meant to be easy to change and extend.
