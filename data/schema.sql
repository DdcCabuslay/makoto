DROP SCHEMA IF EXISTS makoto CASCADE;
CREATE SCHEMA makoto;
SET search_path to makoto;

-- General Tables

CREATE TABLE oem(
	id INT PRIMARY KEY,
	name VARCHAR(20) NOT NULL,
	url VARCHAR(50) NOT NULL
);

CREATE TABLE os(
	id INT PRIMARY KEY,
	version FLOAT(10) NOT NULL,
	name VARCHAR(20) NOT NULL
);

CREATE TABLE processor_oem(
	id INT PRIMARY KEY,
	name VARCHAR(20) NOT NULL
);

CREATE TABLE processor(
	id INT PRIMARY KEY,
	oem_id INT NOT NULL,
	model VARCHAR(20) NOT NULL,
	cores INT NOT NULL,
	main_clock FLOAT(3) NOT NULL,
	secondary_clock FLOAT(3),
	gpu VARCHAR(20) NOT NULL,
	FOREIGN KEY (oem_id) REFERENCES processor_oem(id)
);

CREATE TABLE country(
	id INT PRIMARY KEY,
	name VARCHAR(20) NOT NULL
);

CREATE TABLE vendor(
	id INT PRIMARY KEY,
	name VARCHAR(20) NOT NULL,
	url VARCHAR(50) NOT NULL,
	country_id INT NOT NULL,
	is_carrier BOOLEAN NOT NULL,
	FOREIGN KEY (country_id) REFERENCES country(id)
);

CREATE TABLE colour_group(
	id INT PRIMARY KEY,
	name VARCHAR(10) NOT NULL
);

CREATE TABLE colours(
	id INT PRIMARY KEY,
	colour_group_id INT NOT NULL,
	colour_name VARCHAR(20) NOT NULL,
	colour_hex VARCHAR(6) NOT NULL,
	secondary_colour_hex VARCHAR(6),
	FOREIGN KEY (colour_group_id) REFERENCES colour_group(id)
);

-- Phone Tables

CREATE TABLE display(
	id INT PRIMARY KEY,
	name VARCHAR(10) NOT NULL
);

CREATE TABLE autofocus(
	id INT PRIMARY KEY,
	autofocus_type VARCHAR(20) NOT NULL
);

CREATE TABLE stabilization(
	id INT PRIMARY KEY,
	stabilization_type VARCHAR(20) NOT NULL
);

CREATE TABLE camera_flash(
	id INT PRIMARY KEY, 
	flash_type VARCHAR(20) NOT NULL
);

CREATE TABLE fast_charging(
	id INT PRIMARY KEY,
	name VARCHAR(20) NOT NULL
);

CREATE TABLE usb(
	id INT PRIMARY KEY,
	name VARCHAR(20) NOT NULL
);

CREATE TABLE sim(
	id INT PRIMARY KEY,
	name VARCHAR(20) NOT NULL
);

CREATE TABLE glass(
	id INT PRIMARY KEY,
	name VARCHAR(20) NOT NULL
);

CREATE TABLE phone(
	id INT PRIMARY KEY,
	oem_id INT NOT NULL,
	model VARCHAR(50) NOT NULL,
	release TIMESTAMP NOT NULL,
	-- operating system
	os_id INT NOT NULL,
	upgradable_os_id INT,
	-- display
	display_size FLOAT(3) NOT NULL,
	display_height INT NOT NULL,
	display_width INT NOT NULL,
	display_aspect_ratio VARCHAR(4) NOT NULL,
	display_type_id INT NOT NULL,
	-- camera
	main_camera_res FLOAT(3) NOT NULL,
	main_camera_pixel_size FLOAT(3) NOT NULL,
	main_camera_autofocus_id INT NOT NULL, -- 0 is no/fixed autofocus
	main_camera_stabilization_id INT NOT NULL, -- 0 is no stabilization
	main_camera_aperture FLOAT(2) NOT NULL,
	main_camera_flash_id INT NOT NULL,
	dual_camera_res FLOAT(3),
	dual_camera_pixel_size FLOAT(3),
	dual_camera_autofocus_id INT, -- 0 is no/fixed autofocus
	dual_camera_stabilization_id INT, -- 0 is no stabilization
	dual_camera_aperture FLOAT(2),
	front_camera_res FLOAT(3) NOT NULL,
	front_camera_pixel_size FLOAT(3) NOT NULL,
	front_camera_autofocus_id INT NOT NULL, -- 0 is no/fixed autofocus
	front_camera_stabilization_id INT NOT NULL, -- 0 is no stabilization
	front_camera_aperture FLOAT(2) NOT NULL,
	-- video resolutions will be separate table
	-- processor (separate table)
	processor_id INT NOT NULL,
	-- storage 
	expandable_storage BOOLEAN NOT NULL,
	device_length FLOAT(5) NOT NULL,
	device_width FLOAT(5) NOT NULL,
	device_height FLOAT(5) NOT NULL,
	device_weight FLOAT(4) NOT NULL,
	-- battery 
	battery_size INT NOT NULL,
	fast_charging_id INT NOT NULL, -- 0 is no fast charging
	-- wireless
	wifi_2_4 BOOLEAN NOT NULL,
	wifi_5 BOOLEAN NOT NULL,
	bluetooth_version INT NOT NULL,
	nfc BOOLEAN NOT NULL,
	-- ports
	headphone_jack BOOLEAN NOT NULL,
	usb_id INT NOT NULL,
	sim_id INT NOT NULL,
	-- materials
	glass_id INT,
	water_resistance INT,
	FOREIGN KEY (oem_id) REFERENCES oem(id),
	FOREIGN KEY (os_id) REFERENCES os(id),
	FOREIGN KEY (upgradable_os_id) REFERENCES os(id),
	FOREIGN KEY (display_type_id) REFERENCES display(id),
	FOREIGN KEY (main_camera_stabilization_id) REFERENCES stabilization(id),
	FOREIGN KEY (main_camera_autofocus_id) REFERENCES autofocus(id),
	FOREIGN KEY (main_camera_stabilization_id) REFERENCES stabilization(id),
	FOREIGN KEY (main_camera_flash_id) REFERENCES camera_flash(id),
	FOREIGN KEY (dual_camera_autofocus_id) REFERENCES autofocus(id),
	FOREIGN KEY (dual_camera_stabilization_id) REFERENCES stabilization(id),
	FOREIGN KEY (front_camera_autofocus_id) REFERENCES autofocus(id),
	FOREIGN KEY (front_camera_stabilization_id) REFERENCES stabilization(id),
	FOREIGN KEY (fast_charging_id) REFERENCES fast_charging(id),
	FOREIGN KEY (usb_id) REFERENCES usb(id),
	FOREIGN KEY (sim_id) REFERENCES sim(id),
	FOREIGN KEY (glass_id) REFERENCES glass(id)
);

CREATE TABLE phone_video_resolutions(
	phone_id INT NOT NULL,
	resolution INT NOT NULL,
	fps INT NOT NULL,
	PRIMARY KEY (phone_id, resolution, fps),
	FOREIGN KEY (phone_id) REFERENCES phone(id)
);

CREATE TABLE phone_storage_configurations(
	phone_id INT NOT NULL,
	ram INT NOT NULL,
	storage INT NOT NULL,
	PRIMARY KEY (phone_id, ram, storage),
	FOREIGN KEY (phone_id) REFERENCES phone(id)
);

CREATE TABLE phone_colours(
	phone_id INT NOT NULL,
	colour_id INT NOT NULL,
	PRIMARY KEY (phone_id, colour_id),
	FOREIGN KEY (phone_id) REFERENCES phone(id),
	FOREIGN KEY (colour_id) REFERENCES colours(id)
);

CREATE TABLE phone_pricing(
	phone_id INT NOT NULL,
	vendor_id INT NOT NULL,
	storage INT NOT NULL,
	colour_id INT NOT NULL,
	url VARCHAR(100) NOT NULL,
	price FLOAT(6) NOT NULL,
	PRIMARY KEY (phone_id, vendor_id, storage, colour_id, url, price),
	FOREIGN KEY (phone_id) REFERENCES phone(id),
	FOREIGN KEY (colour_id) REFERENCES colours(id)
);