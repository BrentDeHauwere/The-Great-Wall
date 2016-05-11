# General documentation

> A small part of guidence on how a project for the Integration Project of 2015-2016 of EHB Brussels about EHackB should be styles.

> It provides a boilerplate Template for creating a clear view of the repository for anyone on the team.

[![Template V1.0](https://img.shields.io/badge/Template-V1.0-green.svg)](https://github.com/cezar/github-project-boilerplate) [![Public Domain](https://img.shields.io/badge/proprietary-Closed-lightgrey.svg)](Closed source)

If you read and implement the provides steps and information in this file. Your repository will be up to standard as set by the project managers.<br>

**Project made:** [CHANGELOG-EXAMPLE.md](/) • [CHANGELOG-LICENCE.md](/) • [CHANGELOG.md](/) • [CONTRIBUTING.md](/) • [CONTRIBUTORS.md](/) • [README.md](/) •

## Installing

You can get this repo by ether

- Downloading this repository as a .zip file.
- Unzip it locally and implement the gitlab-boilerplate to the root of your repository.

# Dependencies
- Redis Server
  - Broadcasts will always start with messagewall1.*
  - Channels now in use:
      - `messagewall1.wall.*.messages`

- Node.js
- Server needs to run command `node& socket.js` to run the node server, the socket.js file is found in the root directory of this project.

# Getting Started

- [boilerplate](http://whatis.techtarget.com/definition/boilerplate) (template) files with resumed guidelines for root `README`.

It also includes a basic. All templates are filled under `/template/` folder. This `README` itself is a fork of the `README` [template](template/README.md).

## Usage

### Boilerplate

1. After unpacking the gitlab-boilerplate folder.
2. Move all of the contents of the template folder to the root of your project.
3. If there is already a 'README' in existance. Format it like the template this project provide.
4. If all went well The `README` template as well as the other templates should now be in the the main directory of your project.
5. Now edit the provided guidelines in the respective files. The parts of the 'README' where lines start with `> **[?]**''`
6. Replace the ./project-logo.png file with the log of your project.

  - This logo should be a .png file.
  - With with of "192px" and height of "192px".
  - With 72 x 72 PDI

## Useful Resources

### Boilerplate

> This reposotory is a correct implementation of the template

#### Start

> `README` References

It will cover a Root README. This is uses at root level of the project. It will NOT cover README files inside of the project, that are not in the root, whose covering certain parts or actions that are documented.

- [How To Write A Readme](http://jfhbrook.github.io/2011/11/09/readmes.html)
- [How to Write a Great Readme](https://robots.thoughtbot.com/how-to-write-a-great-readme)
- [Eugene Yokota - StackOverflow Answer](http://stackoverflow.com/a/2304870)

> `CONTRIBUTING` References

- [Setting Guidelines for Repository Contributors](https://help.github.com/articles/setting-guidelines-for-repository-contributors/)
- [Contributor Covenant](http://contributor-covenant.org/)

> `CHANGELOG` References

<https://github.com/zenozeng/gitlab-changelog> This boilerplate file is provides as en example implementation. Using the example from [Keep a Changelog](http://keepachangelog.com/). It was provides to be changed as the format of a changelog.

Every Added Link, and make it obvious that date format is ISO 8601\. Changed Clarified the section on "Is there a standard change log format?". Fixed Fix Markdown links to tag comparison URL with footnote-style links. This boilerplate intentionally did not provide any `CHANGELOG` file as example, since [this tool](https://github.com/skywinder/github-changelog-generator) could make it automatically, fulfilling the file's objective.

If you still want to keep it handwritten, to keep you (and your project) sane, I'd recommend you to follow the references below:

- [Semantic Versioning 2.0.0](http://semver.org/)
- [Keep a Changelog](http://keepachangelog.com/)

> `ISSUE_TEMPLATE` and `PULL_REQUEST_TEMPLATE` References There is no one provided since. Our source control does not need this feature.

## Author

- Brent De Hauwere
- Eli Boey
- Jonas De Pelmaeker
- Kamiel Klumpers

## Acknowledgements

None

## License

Unless otherwise stated in the root. All developed code or intellectual property is propitiatory. In subdirectories, any license included will overrule a license of a higher hierarchical folder. Resulting in the correct accreditation of owners of the intellectual property therof. For an individual file in a subdirectory you can make a license as formated in FILENAME-LICENCE.md, with the licences of the FILENAME therein.
