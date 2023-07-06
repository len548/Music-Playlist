#Music Playlist
<h2>Main page</h2>
On the listing page (a.k.a. the main/index page) a creative title and a short description about the application should be visible as static text.
The main page is also accessible to unauthenticated users who are free to browse the public playlists displayed here.
The following elements should appear for each playlist:
the name of the playlist
the number of tracks in the playlist
the name of the user who created the playlist
and a button the view the details of the playlist
In addition, a mandatory part of the main page is a search field, in which you can search for a track by title.
<h2>Details page</h2>
On the details page, all data about the tracks in the given playlist should be displayed, which means:
the title of the track
the name of the artist
the length of the track
the year the track was released
the list of genres the track has
Logged-in users can add the song they have selected (e.g. from a drop-down menu) to their own playlist from this page.
<h2>Registration/Login pages</h2>
The login and registration page should be accessible from the main page.
During registration users must enter their username, email address, and their password. The password must be entered twice. All fields are required, the email must be a valid email format, and the two passwords must match. In case of an error, display appropriate error messages! The form must be persistent, so after an error, previously filled data should remain in the form. Upon successful registration, save the data and redirect the user to the login page!
On the login page users can identify themselves with their username and password. If there was an error logging in, display a message about it under the login form! After successful login, redirect the user to the main page.
<h2>My playlists</h2>
Logged in users have their own playlists and they can:
Create a new playlist that can be public or private.
Add a new track (found in a public list or using the search) to one of their own playlists.
Remove an already added track from their playlist.