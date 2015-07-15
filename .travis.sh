#!/bin/bash

echo "After Script"
echo "-- Travis Repo Slug: $TRAVIS_REPO_SLUG"
echo "-- Travis PHP Version: $TRAVIS_PHP_VERSION"
echo "-- Travis PULL Request: $TRAVIS_PULL_REQUEST"

if [ "$TRAVIS_REPO_SLUG" == "bluzphp/framework" ] && [ "$TRAVIS_PULL_REQUEST" == "false" ] && [ "$TRAVIS_PHP_VERSION" == "5.6" ]; then

  echo -e "Publishing PHPDoc...\n"

  # move docs to `home` directory
  cp -R docs $HOME/docs-latest

  cd $HOME
  git config --global user.email "travis@travis-ci.org"
  git config --global user.name "travis-ci"
  git clone --quiet https://${GITHUB_TOKEN}@github.com/bluzphp/bluzphp.github.io > /dev/null

  cd bluzphp.github.io
  echo "-- Clean old data"
  git rm -rf ./

  echo "-- Copy"
  cp -Rf $HOME/docs-latest/* ./

  echo "-- Git Push"
  git add -f .
  git commit -m "PHPDocumentor (Travis Build : $TRAVIS_BUILD_NUMBER  - Branch : $TRAVIS_BRANCH)"
  git push -fq origin > /dev/null

  echo -e "Published PHPDoc to github.io\n"

fi