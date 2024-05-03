DO $$ BEGIN
 CREATE TYPE "role" AS ENUM('ADMIN', 'SOCIO', 'MEMBER');
EXCEPTION
 WHEN duplicate_object THEN null;
END $$;
--> statement-breakpoint
ALTER TABLE "contatos_maps_users" ADD COLUMN "role" "role" NOT NULL;