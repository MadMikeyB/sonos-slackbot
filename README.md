# SONOS Slack Bot

A bot built with Symfony\Console which interfaces with the Sonos API's and allows it to be controlled through designated Slack Channels.

Built with ❤️ for [Fifteen](https://www.fifteendesign.co.uk) by [MadMikeyB](http://mikeylicio.us)

## Usage

`php sonosbot slack:listen` Listens to the Slack Channels the bot is currently in.
`php sonosbot sonos:crossfade` Enable Crossfade.
`php sonosbot sonos:crossroads` Play Crossroads by Blazin' Squad
`php sonosbot sonos:info` Get information on the current queue.
`php sonosbot sonos:network` Get the SONOS Network Information
`php sonosbot sonos:next` Skip the current song.
`php sonosbot sonos:pause` Pause the current queue.
`php sonosbot sonos:play` Play the current queue.
`php sonosbot sonos:playlist` Get stored SONOS playlists, see information about them and play them
`php sonosbot sonos:prev` Go back to the previous song.
`php sonosbot sonos:repeat` Repeat the current queue.
`php sonosbot sonos:shuffle` Shuffle the current queue.
`php sonosbot sonos:spotify:add` Add a track from Spotify to the queue.
`php sonosbot sonos:spotify:search` Search Spotify for a track
`php sonosbot sonos:stop` Stop the current queue.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
