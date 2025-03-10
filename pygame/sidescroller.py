import pygame

# Initialize the game
pygame.init()

# Set up the screen
screen = pygame.display.set_mode((800, 600))


# Main game loop
running = True
while running:
       # Move the circle
    keys = pygame.key.get_pressed()
    if keys[pygame.K_LEFT]:
        circle_x -= 5
    if keys[pygame.K_RIGHT]:
        circle_x += 5
    if keys[pygame.K_UP]:
        circle_y -= 5
    if keys[pygame.K_DOWN]:
        circle_y += 5

    # Did the user click the window close button?
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            running = False

    # Fill the background with white
    screen.fill((255, 255, 255))

    # Draw a solid blue circle in the center
    pygame.draw.circle(screen, (0, 0, 255), (400, 300), 50)
 

    # Ensure the circle stays within the screen bounds
    circle_x = max(50, min(circle_x, 750))
    circle_y = max(50, min(circle_y, 550))

    # Flip the display
    pygame.display.flip()

 
