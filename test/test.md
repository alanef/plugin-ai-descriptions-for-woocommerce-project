Curl comment

curl -X POST  -d 'submit=Post Comment' -d 'comment=curlcomment three' -d 'comment_post_ID=5' -d 'comment_parent=0' -d 'author=alan' -d 'email=abc@def.com' http://localhost:8350/wp-comments-post.php


Curl WpDiscuz ( not workin! )

curl -X POST  -d 'submit=Post Comment' -d 'wpdiscuz_nonce' -d 'wc_comment=discuz curlcomment dhhdhd jjd duj' -d 'postId=5'  -d 'wc_name=alan' -d 'wc_email=abc@def.com' -d 'wpdiscuz_unique_id=0_0' -d 'wpd_comment_depth=1' -d 'action=wpdAddComment' -d 'wmu_files[]' -d 'wc_website' http://localhost:8350/wp-comments-post.php