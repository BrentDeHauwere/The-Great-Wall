# Keep a CHANGELOG

## There is no standard change log format?

This project was made to define the 'CHANGELOG' file moe clearly. It is an implementation of [Keep a changelog](http://http://keepachangelog.com/). Formated so it is relatively clear for both on developer or manager level.

## Writing our own change log?

Well we need to write our doc. We could generate it but not with our implementations

It's also possible you may discover that you forgot to address a breaking change in the notes for a version. It's obviously important for you to update your change log in this case.

## Follow these guidelines

- One sub-section per version.
- Always have an `"Unreleased"` section at the top for keeping track of any changes.
- List releases in reverse-chronological order (newest on top).
- Write all of the dates in `YYYY-MM-DD` format. (Example: `2016-04-20` for `April 20nd, 2016`.)
- Explicitly mention the project follows [Semantic Versioning](http://semver.org/).
- Each version of CHANGELOG.md should:

  - List its release date in the above format.
  - Group changes to describe their impact on the project, as follows:

    - `Added` for new features.
    - `Changed` for changes in existing functionality.
    - `Deprecated` for once-stable features removed in upcoming releases.
    - `Removed` for deprecated features removed in this release.
    - `Fixed` for any bug fixes.
    - `Security` to invite users to upgrade in case of vulnerabilities.

### Tags on releases?

On release level there are not tag normaly.

```markdown
`## 0.0.5 - 2014-12-13 [YANKED]`

The `[YANKED]` tag is loud for a reason. It's important for people to notice it. Since it's surrounded by brackets it's also easier to parse programmatically. If a version should be disable due to bugs or security reasons. The versions should be marked 'YANKED'. This YANKED' will be enclosed with squire brackets set behind the version and release date.
```

## Dont's

- **Dumping a diff of commit logs.** Just don't do that, you're helping nobody.
- **Not emphasizing deprecations.** When people upgrade from one version to another, it should be painfully clear when something will break. This could be done by committing the right code.
