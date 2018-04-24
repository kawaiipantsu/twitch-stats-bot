# ᵔᴥᵔ Twitch(TV) Stats Bot
[![Twitter Follow](https://img.shields.io/twitter/follow/davidbl.svg?style=social&label=Follow)](https://twitter.com/davidbl) [![GitHub issues](https://img.shields.io/github/issues/kawaiipantsu/twitch-stats-bot.svg)](https://github.com/kawaiipantsu/twitch-stats-bot/issues) [![GitHub closed issues](https://img.shields.io/github/issues-closed/kawaiipantsu/twitch-stats-bot.svg)](https://github.com/kawaiipantsu/twitch-stats-bot/issues) [![GitHub license](https://img.shields.io/github/license/kawaiipantsu/twitch-stats-bot.svg)](https://github.com/kawaiipantsu/twitch-stats-bot/blob/master/LICENSE) [![GitHub forks](https://img.shields.io/github/forks/kawaiipantsu/twitch-stats-bot.svg)](https://github.com/kawaiipantsu/twitch-stats-bot/network) [![GitHub stars](https://img.shields.io/github/stars/kawaiipantsu/twitch-stats-bot.svg)](https://github.com/kawaiipantsu/twitch-stats-bot/stargazers)
> I love data! A none intrusive Twitch TV bot to collect all the data!

[![Twitch TV](https://upload.wikimedia.org/wikipedia/commons/thumb/2/26/Twitch_logo.svg/1024px-Twitch_logo.svg.png)](http://www.twitch.tv)

So Twitch TV is one of my favorite places to get entertained from time to time when I'm coding or just taking a breather from work etc. I like to tune in and look if any of my broadcasters I'm following is online or to browse games I like...

But one of the big topics on Twitch amongst broadcasters and viewers seems to be viewer count, sub count, donations, schedules, games played and all the rest. It all makes sense to keep an eye on all of this and data and analyzing  data is something that interest me a hole deal - So I wanted to make a simple but "HPC" aka High Performance Computing bot that could handle huge data amounts and preferably also at high data rates then store all of this in a backend database for later analysis/presentation via a web interface.

> But first part would be to build the bot aka the backend.
> Then move on to the frontend part aka the website and presentation of the data.

## Table of contents

 * [Thoughts and ideas](#)
 * [Features](#)
 * [My TODO list](#)
 * [Why PHP?](#)
 * [What data is collected](#)
   * [Detailed collection information](#)
 * [Analyze the data](#)
 * [Outside contributions](#)
 * [The bot, should I run it myself?](#)
 * [Donations](#)
 * [References](#)
 * [Reporting Bugs](#)
 * [Subscribe](#)

## Thoughts and ideas

These are my current thoughts and ideas! As this is very much a project in it's early stage I have not yet even settled on how my code is going to be build or structured. I just know that I want it to be able to handle vast amounts of data and at a fast speed. So what I think of from there is what you see below. Once things are chewed over and seems like a good idea I will move it to my TODO list. 

* Find a way to implement data-modules into the bot design
 * Bot needs to be threaded (using posix)
   * So far I have settled on two main threads, SQL and IRC
   * All data-modules will run in their own thread for high performance
 * Look into lib event for thread communication
 * Obay posix PID solution for process monitoring
 * Optimized for low i/o usage, take advantage of op-cache ?
 * Build a flexible database structure and create tables
 * Flexible internal logging
   * Log to local log files (option to turn off to save i/o)
   * Log to syslog so you can fit in large scale installations and infrastructures
 * Thread monitoring to restart etc modules or main threads
 * Libs for handling irc, sql and so on
 * Figure out how you want to structure the code
 * Do we OOP or just trash it out, reasons for both?
 * Use FIFO as queue system with each worker also some sort of buffer queue for incomming data

## Features

* *sigh* - Nothing yet :)

Check the Wiki for Development blog intries and more information on what i'm currently working on!
[Project Wiki / Developer Blog](https://github.com/kawaiipantsu/twitch-stats-bot/wiki)

## My TODO list

The TODO list is a combination of my thoughts and ideas that have been approved and on paper sounds like its doable :) Once a thing from my TODO list is done that is actually a feature I will move it up under Features.

 * *sigh* - Nothing yet :)
 
 Check the Wiki for Development blog intries and more information on what i'm currently working on!
[Project Wiki / Developer Blog](https://github.com/kawaiipantsu/twitch-stats-bot/wiki)

## Why PHP?

I have a great love hate relationship with PHP, so it's only natural for me to use it. I personally like the performance of PHP vs. things like Python or Perl. By this I mean things like what's available to you can how fast can you find a solution to a problem. Also since my websites use PHP it's an easy integration and seemingness workflow to jump between backend and frontend.

## What data is collected

This is one of the big issues, what can we collect and what can you actually show to the public. This bot is connecting to their (TwitchTV) chat service as any other user. So all data it can see is what's already public to their users when logged into their (TwitchTV) site. The bot will have no special access or special treatment like being a Moderator.

This also means that I can show all the data to anyone who has a valid TwitchTV login and that's my plan.
The UI/frontend I'm making later on when the backend is running will require anyone who wants to look to authenticate with TwitchTV to view the data - By doing so I'm sure that anyone who views the data is a TwitchTV user.

> Also it's worth noticing that this is just chat, streaming, timestamps and basic data collected.
> For most people it's not that exiting to look at, but "some" (me) like to correlate, analyze and look at data like this - So I have to build something that gives me this option!

I have by the way considered to add the feature so broadcasters can login and lock part of their collected data if they don't want it to be shown, but this is still something I'm considering as I don't want to restrict data that is already public to all TwitchTV users.

### Detailed collection information

Still not really an issue yet, the hole bot and backend needs to function first.
I will update this README as the project goes on. 

## Analyze the data

All data collected is stored in a database backend for later analysis. The current state of the project is to build the backend and to streamline the process of collecting and storing the data. The idea is to have "data-modules" that can work with the raw data from TwtichTV and then store it.

The plan was to make this a way for others to contribute data-modules and for me to "step back" to work on other things. But I would at least need some basic modules down to begin with so this is something that will come in the future for now all data-modules will be made by me and perhaps on request.

## Outside contributions

I always welcome contributions from the outside. If you think I need to add a specific feature or you want to help me correct something that is wrong just mention it and I'll fix it right away. Also I'm trying to build this bot so that we can "contribute" with (I call them data-modules) data-modules to update the bot in what data is collected and what we do with it. For now all contributions will be archived and I'll take a look at them when the bot is done.

## The bot, should I run it myself?

Honestly I don't see a reason why you would, unless you want to have a way to store the data locally for your own viewing pleasure etc. I only keep the code here as I think it should be public so that there really is a "transparency" about what data actually get's collected, if anyone wants to look though the code.

Also I encourage people to fetch/clone my code if they just want to keep the source safe or to play around with it to modify it or even make it better! In the future I will take this "bot code" and make a more basic example of it so anyone who wants to make a highly modular Twitch to can do so, or at least it's something I have been thinking about but for now this code is pretty much dedicated to this project and I don't think I'll make it easy to convert it but you are more than welcome to use it for what ever purpose, just let me know. It interest me to see what others do to it to!

## Donations

I thought about this and I don't think it's unreasonable to ask for, my idea with this bot was to create a "semi" public approach to Twitch TV statistical data but also I know it will require vast amounts of storage space so I'm hosting this on AWS/Amazon Web Services or at least when the project is done that's my idea to take advantage of their storage solutions. But that is not cheap but also it's not that expensive so I think that a few donations here and there should keep the project a float.

Since it's Twitch, let's keep it in the streaming spirit :)
Tip my Twitch User [ReadyUpDave](http://streamlabs.com/readyupdave) or perhaps give me "bits" directly on my channel via [Twitch TV](https://www.twitch.tv/readyupdave).

You can also donate Bitcoins or Ethereum to me for maintaining the project.

> Bitcoin address - 31jzgaJZuzGhDZQYrDTHQzmRFYnvHhzr57

> Ethereum address - 0x39BA5839830E9207FF3aC1c21d08d636548009D4

## References

When I find something online that I think I can use, implement or otherwise lean from when building my bot I will paste it here. There is of course a couple of major references that keeps popping up again and again. These are listed below to.

> Official Twitch TV references used
 * [Twitch TV Developer Site](https://dev.twitch.tv)
 * [Twitch TV API Documentation](https://dev.twitch.tv/docs/api)
 * [Twitch TV Developer Forums](https://discuss.dev.twitch.tv)

## Reporting Bugs

Report all issues in the [issues tracker](https://github.com/kawaiipantsu/twitch-stats-bot/issues).

## Subscribe

Stay tuned to new releases with the project [feeds](https://github.com/kawaiipantsu/twitch-stats-bot/releases.atom).
