# Image Uploads

Since uploading images is a complex problem that I have thought a lot about, I have decided to add my thoughts here.

## Post Images

## User Profile Images

## Deleting Images
To save disk space, images that are not in use should be deleted. For example, if a user posts an image, then the post is deleted, the image associated with the post should also be deleted.

- Hanging Images: This could introduce some problems. For example, what if someone was currently fetching the image while the server attempted to delete it? Then the image might be left permanently in the uploaded images folder. 
    - Decision: We will still allow the user to change their profile picture, even if we cannot delete their old one. And in the future, we will have a regularly executing program that will delete any of these "hanging images".
