<?php
get_header();
?>

	<main class="main-content">
		<div class="wrapper">
			<?php get_template_part('template-parts/breadcrumbs') ?>
        </div>
        <?php
            if (have_posts()):
            while (have_posts()):
                the_post();
	    ?>
		    <article class="main-article wrapper">
			<header class="main-article__header">
                <?php
                    $full_img = get_field('full_image');
                    if ($full_img) {
                        $url = $full_img['url'];
                        $alt = $full_img['alt'];
                        echo "<img src=\"$url\" alt=\"$alt\" class=\"main-article__thumb\"/>";
                    } else {
	                    the_post_thumbnail( 'full', [ 'class' => 'main-article__thumb' ] );
                    }
                ?>
				<h1 class="main-article__h"><?php the_title() ?></h1>
			</header>
			<?php  the_content();?>
			<footer class="main-article__footer">
				<time datetime="<?php echo get_the_date('Y m d')?>"><?php echo get_the_date('d M Y')?></time>
				<button
                    class="main-article__like like"
                    style="background: transparent; font-size: 16px; font-family: inherit"
                    id="<?php echo $id?>"
                    data-href="<?php echo esc_url(admin_url('admin-ajax.php'))?>"
                >
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 51.997 51.997" style="enable-background:new 0 0 51.997 51.997;" xml:space="preserve">
              <style> path{
                      fill: #666;
                  }
              </style>
						<path d="M51.911,16.242C51.152,7.888,45.239,1.827,37.839,1.827c-4.93,0-9.444,2.653-11.984,6.905
	c-2.517-4.307-6.846-6.906-11.697-6.906c-7.399,0-13.313,6.061-14.071,14.415c-0.06,0.369-0.306,2.311,0.442,5.478
	c1.078,4.568,3.568,8.723,7.199,12.013l18.115,16.439l18.426-16.438c3.631-3.291,6.121-7.445,7.199-12.014
	C52.216,18.553,51.97,16.611,51.911,16.242z" />
						<g>
						</g>
						<g>
						</g>
						<g>
						</g>
						<g>
						</g>
						<g>
						</g>
						<g>
						</g>
						<g>
						</g>
						<g>
						</g>
						<g>
						</g>
						<g>
						</g>
						<g>
						</g>
						<g>
						</g>
						<g>
						</g>
						<g>
						</g>
						<g>
						</g>
            </svg>
					<span class="like__text">Нравится </span>
					<span class="like__count">
                        <?php
                            $likes = get_post_meta( $id,'sc-likes', true);
                            $likes = $likes ? $likes : '0';
                            echo $likes;
                        ?>
                    </span>
				</button>
                <script>
                    window.addEventListener('load', function () {
                        const btnItem = document.querySelector('.like')
                        const postId = btnItem.getAttribute('id')
                        const url = btnItem.getAttribute('data-href')

                        try {
                            if (!localStorage.getItem('liked')) {
                                localStorage.setItem('liked', '')
                            }
                        } catch (e) {
                            console.log(e)
                        }

                        function checkLikedPost(id) {
                            let postLiked = false
                            try {
                                postLiked = localStorage.getItem('liked').split(',').includes(id)
                            } catch (e) {
                                console.log(e)
                            }
                            return postLiked
                        }

                        let hasLiked = checkLikedPost(postId)
                        if (hasLiked) {
                            btnItem.classList.add('like_liked')
                        }


                        btnItem.addEventListener('click', function (e) {
                            e.preventDefault()
                            btnItem.disabled = true
                            let hasLiked = checkLikedPost(postId)
                            const formData = new FormData()
                            let todo = hasLiked ? 'minus' : 'plus'
                            formData.append('action', 'post-likes')
                            formData.append('todo', todo)
                            formData.append('id', postId)
                            const xhr = new XMLHttpRequest()
                            xhr.open('POST', btnItem.getAttribute('data-href'))
                            xhr.send(formData)
                            xhr.addEventListener('readystatechange', function () {
                                if (xhr.readyState !== 4) return;
                                if (xhr.status === 200) {
                                    btnItem.querySelector('.like__count').innerText = xhr.responseText
                                    let localData = localStorage.getItem('liked')
                                    let newData = ''
                                    if (hasLiked) {
                                        newData = localData.split(',').filter( function(likeId) {
                                            return likeId !== postId
                                        }).join(',')
                                    } else {
                                        newData = localData.split(',').filter(function (likeId) {
                                            return likeId !== ''
                                        }).concat(postId).join(',')
                                    }
                                    localStorage.setItem('liked', newData)
                                    btnItem.classList.toggle('like_liked')
                                }
                                btnItem.disabled = false

                            })


                        })
                    })
                </script>
			</footer>
		</article>
        <?php
            endwhile;
            endif;
        ?>
	</main>

<?php
get_footer();
?>